<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Retrieve a setting value by key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        try {
            return static::query()
                ->where('key', $key)
                ->value('value') ?? $default;
        } catch (QueryException) {
            // During early bootstrap the table might not exist yet.
            return $default;
        }
    }

    /**
     * Create or update a setting value.
     */
    public static function updateValue(string $key, mixed $value): self
    {
        return static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Resolve landing video metadata (path, url, mime).
     *
     * @return array{path: ?string, url: ?string, mime: ?string}
     */
    public static function landingVideoMeta(): array
    {
        $path = static::getValue('landing_video_path');
        if (!$path) {
            return ['path' => null, 'url' => null, 'mime' => null];
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            return ['path' => null, 'url' => null, 'mime' => null];
        }

        $normalizedPath = ltrim($path, '/');
        $extension = strtolower(pathinfo($normalizedPath, PATHINFO_EXTENSION));
        $mimeMap = [
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
            'ogv' => 'video/ogg',
        ];

        $version = null;
        try {
            $version = @filemtime($disk->path($normalizedPath)) ?: null;
        } catch (\Throwable) {
            $version = null;
        }

        $url = URL::to('/landing/video');
        if ($version) {
            $url .= (str_contains($url, '?') ? '&' : '?') . '_v=' . $version;
        }

        return [
            'path' => $normalizedPath,
            'url' => $url,
            'mime' => $mimeMap[$extension] ?? null,
        ];
    }

    /**
     * Retrieve selected landing theme.
     */
    public static function landingTheme(string $default = 'aurora'): string
    {
        $value = static::getValue('landing_theme', $default);
        return is_string($value) && $value !== '' ? $value : $default;
    }

    /**
     * Resolve the active landing theme color surfaces.
     *
     * @return array<string, string>
     */
    public static function landingThemeSurfaces(): array
    {
        $defaults = [
            'surface1' => 'linear-gradient(140deg, #0b1220 0%, #05060a 55%, #020205 100%)',
            'surface2' => 'rgba(12,19,33,0.92)',
            'surface3' => 'rgba(18,35,64,0.65)',
            'accent' => '#38bdf8',
            'accentSoft' => '#dbeafe',
            'text_primary' => '#e2e8f0',
            'text_secondary' => 'rgba(226, 232, 240, 0.75)',
        ];

        $themeKey = static::landingTheme();
        $presets = config('bpip.landing_themes', []);
        $surfaces = data_get($presets, "{$themeKey}.surfaces", []);

        if (!is_array($surfaces)) {
            $surfaces = [];
        }

        return array_merge($defaults, array_filter($surfaces));
    }

    /**
     * Resolve global dashboard/page header variant.
     */
    public static function dashboardHeroVariant(string $default = 'ocean'): string
    {
        $stored = static::getValue('dashboard_hero_variant');
        if (is_string($stored) && in_array($stored, ['ocean', 'slate'], true)) {
            return $stored;
        }

        // Backward-compatible fallback: infer from landing theme when no explicit setting exists.
        $theme = static::landingTheme();
        return $theme === 'aurora' ? 'ocean' : 'slate';
    }

    /**
     * Default page activation toggles used by menu and middleware guards.
     *
     * @return array<string, bool>
     */
    public static function defaultPageToggles(): array
    {
        return [
            'assets_loanable' => true,
            'assets_inventory' => true,
            'loans' => true,
            'reports' => true,
            'users' => true,
        ];
    }

    /**
     * Resolve page toggles from storage with sane defaults.
     *
     * @return array<string, bool>
     */
    public static function pageToggles(): array
    {
        $defaults = static::defaultPageToggles();
        $stored = static::getValue('admin_page_toggles');

        if (!is_string($stored) || trim($stored) === '') {
            return $defaults;
        }

        $decoded = json_decode($stored, true);
        if (!is_array($decoded)) {
            return $defaults;
        }

        $normalized = [];
        foreach ($defaults as $key => $defaultValue) {
            $normalized[$key] = array_key_exists($key, $decoded)
                ? (bool) $decoded[$key]
                : $defaultValue;
        }

        return $normalized;
    }

    public static function isPageEnabled(string $key): bool
    {
        $toggles = static::pageToggles();
        return $toggles[$key] ?? true;
    }

    /**
     * @param array<string, mixed> $toggles
     */
    public static function setPageToggles(array $toggles): void
    {
        $defaults = static::defaultPageToggles();
        $payload = [];

        foreach ($defaults as $key => $defaultValue) {
            $payload[$key] = array_key_exists($key, $toggles)
                ? (bool) $toggles[$key]
                : $defaultValue;
        }

        static::updateValue('admin_page_toggles', json_encode($payload));
    }

    /**
     * @return array<string, array<string, bool>>
     */
    public static function defaultRolePageAccess(): array
    {
        return [
            'assets_loanable' => [
                User::ROLE_PEMINJAM => true,
                User::ROLE_PETUGAS => true,
                User::ROLE_SUPER_ADMIN => true,
            ],
            'assets_inventory' => [
                User::ROLE_PEMINJAM => false,
                User::ROLE_PETUGAS => true,
                User::ROLE_SUPER_ADMIN => true,
            ],
            'loans' => [
                User::ROLE_PEMINJAM => true,
                User::ROLE_PETUGAS => true,
                User::ROLE_SUPER_ADMIN => true,
            ],
            'reports' => [
                User::ROLE_PEMINJAM => false,
                User::ROLE_PETUGAS => true,
                User::ROLE_SUPER_ADMIN => true,
            ],
            'users' => [
                User::ROLE_PEMINJAM => false,
                User::ROLE_PETUGAS => true,
                User::ROLE_SUPER_ADMIN => true,
            ],
        ];
    }

    /**
     * @return array<string, array<string, bool>>
     */
    public static function rolePageAccess(): array
    {
        $defaults = static::defaultRolePageAccess();
        $stored = static::getValue('admin_role_page_access');

        if (!is_string($stored) || trim($stored) === '') {
            return $defaults;
        }

        $decoded = json_decode($stored, true);
        if (!is_array($decoded)) {
            return $defaults;
        }

        $normalized = [];
        foreach ($defaults as $pageKey => $roleFlags) {
            $normalized[$pageKey] = [];
            foreach ($roleFlags as $role => $defaultAllowed) {
                $normalized[$pageKey][$role] = array_key_exists($role, $decoded[$pageKey] ?? [])
                    ? (bool) ($decoded[$pageKey][$role] ?? false)
                    : $defaultAllowed;
            }
        }

        return $normalized;
    }

    public static function isRoleAllowedForPage(?string $role, string $pageKey): bool
    {
        if (!$role) {
            return true;
        }

        $access = static::rolePageAccess();
        if (!isset($access[$pageKey])) {
            return true;
        }

        return (bool) ($access[$pageKey][$role] ?? false);
    }

    /**
     * @param array<string, array<string, mixed>> $accessMap
     */
    public static function setRolePageAccess(array $accessMap): void
    {
        $defaults = static::defaultRolePageAccess();
        $payload = [];

        foreach ($defaults as $pageKey => $roleFlags) {
            $payload[$pageKey] = [];
            foreach ($roleFlags as $role => $defaultAllowed) {
                $payload[$pageKey][$role] = array_key_exists($role, $accessMap[$pageKey] ?? [])
                    ? (bool) ($accessMap[$pageKey][$role] ?? false)
                    : $defaultAllowed;
            }
        }

        static::updateValue('admin_role_page_access', json_encode($payload));
    }

    public static function adminBroadcast(): ?string
    {
        $text = static::getValue('admin_broadcast_message');
        if (!is_string($text)) {
            return null;
        }

        $trimmed = trim($text);
        return $trimmed === '' ? null : $trimmed;
    }

    public static function setAdminBroadcast(?string $message): void
    {
        $value = $message !== null ? trim($message) : null;
        static::updateValue('admin_broadcast_message', $value !== '' ? $value : null);
    }

    /**
     * @return array<string, array<string, bool>>
     */
    public static function togglePresets(): array
    {
        return [
            'normal' => [
                'assets_loanable' => true,
                'assets_inventory' => true,
                'loans' => true,
                'reports' => true,
                'users' => true,
            ],
            'maintenance' => [
                'assets_loanable' => false,
                'assets_inventory' => false,
                'loans' => false,
                'reports' => false,
                'users' => false,
            ],
            'operasional' => [
                'assets_loanable' => true,
                'assets_inventory' => true,
                'loans' => true,
                'reports' => false,
                'users' => false,
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function adminAuditLogs(): array
    {
        $raw = static::getValue('admin_menu_audit_log');
        if (!is_string($raw) || trim($raw) === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<string, mixed> $entry
     */
    public static function appendAdminAuditLog(array $entry): void
    {
        $logs = static::adminAuditLogs();
        array_unshift($logs, $entry);
        $logs = array_slice($logs, 0, 40);

        static::updateValue('admin_menu_audit_log', json_encode($logs));
    }

    public static function clearAdminAuditLogs(): void
    {
        static::updateValue('admin_menu_audit_log', json_encode([]));
    }

    public static function currentSystemMode(): string
    {
        $current = static::pageToggles();
        foreach (static::togglePresets() as $mode => $preset) {
            if ($preset == $current) {
                return $mode;
            }
        }

        return 'custom';
    }

    /**
     * @return array{label:string,badge:string}
     */
    public static function currentSystemModeMeta(): array
    {
        return match (static::currentSystemMode()) {
            'maintenance' => ['label' => 'Maintenance', 'badge' => 'danger'],
            'operasional' => ['label' => 'Operasional', 'badge' => 'primary'],
            'normal' => ['label' => 'Normal', 'badge' => 'success'],
            default => ['label' => 'Custom', 'badge' => 'warning'],
        };
    }
}
