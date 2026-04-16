<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * @param array<string, array<string, bool>> $before
     * @param array<string, array<string, bool>> $after
     * @param array<string, array{label:string,desc:string}> $menuItems
     * @param array<string, string> $roleLabels
     * @return array<int, string>
     */
    private function summarizeRoleAccessChanges(array $before, array $after, array $menuItems, array $roleLabels): array
    {
        $changes = [];

        foreach ($after as $pageKey => $rolesAfter) {
            $pageLabel = $menuItems[$pageKey]['label'] ?? $pageKey;
            $rolesBefore = $before[$pageKey] ?? [];
            $roleChanges = [];

            foreach ($rolesAfter as $roleKey => $allowedAfter) {
                $allowedBefore = (bool) ($rolesBefore[$roleKey] ?? false);
                if ($allowedBefore === (bool) $allowedAfter) {
                    continue;
                }

                $roleLabel = $roleLabels[$roleKey] ?? $roleKey;
                $roleChanges[] = sprintf('%s %s', $roleLabel, $allowedAfter ? 'ON' : 'OFF');
            }

            if (!empty($roleChanges)) {
                $changes[] = sprintf('%s: %s', $pageLabel, implode(', ', $roleChanges));
            }
        }

        return $changes;
    }

    /**
     * @return array{0: array<int, array<string, mixed>>, 1: ?string}
     */
    private function filteredAdminLogs(Request $request): array
    {
        $selectedDate = $request->query('log_date');
        $auditLogs = SiteSetting::adminAuditLogs();

        if (is_string($selectedDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate) === 1) {
            $auditLogs = array_values(array_filter($auditLogs, static function ($log) use ($selectedDate) {
                $at = is_array($log) ? ($log['at'] ?? null) : null;
                return is_string($at) && str_starts_with($at, $selectedDate);
            }));
        } else {
            $selectedDate = null;
        }

        return [$auditLogs, $selectedDate];
    }

    /**
     * Show super admin menu/page control settings.
     */
    public function adminMenu(): View
    {
        [$auditLogs, $selectedDate] = $this->filteredAdminLogs(request());

        $menuItems = [
            'assets_loanable' => ['label' => 'Data Barang', 'desc' => 'Menu publik daftar barang yang bisa dipinjam.'],
            'assets_inventory' => ['label' => 'Data Aset', 'desc' => 'Manajemen inventaris internal.'],
            'loans' => ['label' => 'Peminjaman', 'desc' => 'Form dan proses transaksi peminjaman.'],
            'reports' => ['label' => 'Laporan', 'desc' => 'Halaman laporan ringkasan dan ekspor.'],
            'users' => ['label' => 'Daftar Anggota', 'desc' => 'Administrasi akun pengguna.'],
        ];

        $videoMeta = SiteSetting::landingVideoMeta();

        $perPage = 10;
        $currentPage = max((int) request()->query('page', 1), 1);
        $total = count($auditLogs);
        $offset = ($currentPage - 1) * $perPage;
        $items = array_slice($auditLogs, $offset, $perPage);

        $auditPaginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => route('settings.admin-menu'),
                'query' => request()->except('page'),
            ]
        );

        return view('settings.admin-menu', [
            'pageToggles' => SiteSetting::pageToggles(),
            'rolePageAccessMap' => SiteSetting::rolePageAccess(),
            'roleLabels' => User::ROLE_LABELS,
            'broadcastMessage' => SiteSetting::adminBroadcast(),
            'presetKeys' => array_keys(SiteSetting::togglePresets()),
            'auditLogs' => $auditPaginator,
            'selectedLogDate' => $selectedDate,
            'menuItems' => $menuItems,
            'videoUrl' => $videoMeta['url'],
            'videoMime' => $videoMeta['mime'],
            'videoPath' => $videoMeta['path'],
            'currentHeroVariant' => SiteSetting::dashboardHeroVariant(),
        ]);
    }

    public function exportAdminMenuLogs(Request $request): StreamedResponse
    {
        [$auditLogs] = $this->filteredAdminLogs($request);

        $filename = 'audit-super-admin-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(static function () use ($auditLogs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Waktu', 'Aktor', 'Email', 'Mode', 'Perubahan Menu', 'Broadcast Sebelum', 'Broadcast Sesudah']);

            foreach ($auditLogs as $log) {
                $changed = is_array($log['changed_keys'] ?? null) ? implode(', ', $log['changed_keys']) : '-';
                fputcsv($handle, [
                    $log['at'] ?? '-',
                    $log['actor'] ?? '-',
                    $log['actor_email'] ?? '-',
                    $log['preset'] ? ucfirst((string) $log['preset']) : 'Manual',
                    $changed,
                    $log['broadcast_before'] ?? '-',
                    $log['broadcast_after'] ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Update super admin page activation and broadcast settings.
     */
    public function updateAdminMenu(Request $request): RedirectResponse
    {
        $defaults = SiteSetting::defaultPageToggles();
        $toggleKeys = array_keys($defaults);
        $presets = SiteSetting::togglePresets();
        $roleAccessDefaults = SiteSetting::defaultRolePageAccess();
        $menuItems = [
            'assets_loanable' => ['label' => 'Data Barang', 'desc' => 'Menu publik daftar barang yang bisa dipinjam.'],
            'assets_inventory' => ['label' => 'Data Aset', 'desc' => 'Manajemen inventaris internal.'],
            'loans' => ['label' => 'Peminjaman', 'desc' => 'Form dan proses transaksi peminjaman.'],
            'reports' => ['label' => 'Laporan', 'desc' => 'Halaman laporan ringkasan dan ekspor.'],
            'users' => ['label' => 'Daftar Anggota', 'desc' => 'Administrasi akun pengguna.'],
        ];
        $maxKb = (int) config('bpip.landing_video_max_kb', 71680);
        $allowedMimes = implode(',', config('bpip.landing_video_mimes', ['mp4', 'webm', 'ogg']));

        $rules = [
            'broadcast_message' => ['nullable', 'string', 'max:300'],
            'preset_mode' => ['nullable', Rule::in(array_keys($presets))],
            'role_access' => ['nullable', 'array'],
            'landing_video' => ['nullable', 'file', 'mimes:' . $allowedMimes, 'max:' . $maxKb],
            'remove_video' => ['nullable', 'boolean'],
            'hero_variant' => ['nullable', Rule::in(['ocean', 'slate'])],
        ];

        foreach ($toggleKeys as $key) {
            $rules[$key] = ['nullable', 'boolean'];
        }

        $validated = $request->validate($rules);

        $presetMode = $validated['preset_mode'] ?? null;

        if ($presetMode && isset($presets[$presetMode])) {
            $toggles = $presets[$presetMode];
        } else {
            $toggles = [];
            foreach ($toggleKeys as $key) {
                $toggles[$key] = $request->boolean($key);
            }
        }

        $actor = $request->user();
        $currentToggles = SiteSetting::pageToggles();
        $currentRoleAccess = SiteSetting::rolePageAccess();
        $currentBroadcast = SiteSetting::adminBroadcast();
        $currentVideoPath = SiteSetting::getValue('landing_video_path');
        $currentHeroVariant = SiteSetting::dashboardHeroVariant();

        $newVideoPath = is_string($currentVideoPath) ? $currentVideoPath : null;
        if ($request->boolean('remove_video')) {
            if ($newVideoPath) {
                Storage::disk('public')->delete($newVideoPath);
            }
            $newVideoPath = null;
        }

        if ($request->hasFile('landing_video')) {
            $uploadedPath = $request->file('landing_video')->store('landing', 'public');
            if ($newVideoPath) {
                Storage::disk('public')->delete($newVideoPath);
            }
            $newVideoPath = $uploadedPath;
        }

        SiteSetting::updateValue('landing_video_path', $newVideoPath);

        $selectedHeroVariant = $validated['hero_variant'] ?? null;
        if ($selectedHeroVariant && $selectedHeroVariant !== $currentHeroVariant) {
            SiteSetting::updateValue('dashboard_hero_variant', $selectedHeroVariant);
        }

        $newHeroVariant = SiteSetting::dashboardHeroVariant();

        $newRoleAccess = $currentRoleAccess;
        $hasRoleAccessInput = $request->has('role_access');
        if ($hasRoleAccessInput) {
            $newRoleAccess = [];
            foreach ($roleAccessDefaults as $pageKey => $roles) {
                $newRoleAccess[$pageKey] = [];
                foreach ($roles as $role => $allowed) {
                    $newRoleAccess[$pageKey][$role] = $request->boolean("role_access.$pageKey.$role");
                }
            }
        }

        SiteSetting::setPageToggles($toggles);
        SiteSetting::setRolePageAccess($newRoleAccess);

        $newBroadcast = array_key_exists('broadcast_message', $validated)
            ? $validated['broadcast_message']
            : $currentBroadcast;
        SiteSetting::setAdminBroadcast($newBroadcast);

        $roleAccessChanged = $this->summarizeRoleAccessChanges(
            $currentRoleAccess,
            $newRoleAccess,
            $menuItems,
            User::ROLE_LABELS
        );

        SiteSetting::appendAdminAuditLog([
            'at' => now()->toDateTimeString(),
            'actor' => $actor?->name ?? 'unknown',
            'actor_email' => $actor?->email,
            'preset' => $presetMode,
            'changed_keys' => array_keys(array_diff_assoc($toggles, $currentToggles)),
            'role_access_changed' => $roleAccessChanged,
            'toggles_before' => $currentToggles,
            'toggles_after' => $toggles,
            'role_access_before' => $currentRoleAccess,
            'role_access_after' => $newRoleAccess,
            'broadcast_before' => $currentBroadcast,
            'broadcast_after' => $newBroadcast,
            'landing_video_before' => $currentVideoPath,
            'landing_video_after' => $newVideoPath,
            'hero_variant_before' => $currentHeroVariant,
            'hero_variant_after' => $newHeroVariant,
        ]);

        return redirect()
            ->route('settings.admin-menu')
            ->with('status', $presetMode
                ? 'Preset ' . ucfirst($presetMode) . ' berhasil diterapkan.'
                : 'Pengaturan Super Admin berhasil diperbarui.');
    }

    public function clearAdminMenuLogs(): RedirectResponse
    {
        SiteSetting::clearAdminAuditLogs();

        return redirect()
            ->route('settings.admin-menu')
            ->with('status', 'Audit log pengaturan berhasil dihapus.');
    }
}
