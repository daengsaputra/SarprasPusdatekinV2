<?php

namespace App\Http\Controllers;

use App\Models\SsoRoleOverride;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SsoRoleOverrideController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $overrides = SsoRoleOverride::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nip', 'like', "%{$q}%")
                      ->orWhere('name', 'like', "%{$q}%");
                });
            })
            ->orderBy('role')
            ->orderBy('nip')
            ->paginate(25)
            ->withQueryString();

        return view('settings.sso-role-overrides.index', [
            'overrides' => $overrides,
            'q'         => $q,
            'roleLabels' => User::ROLE_LABELS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip'  => ['required', 'string', 'max:32'],
            'role' => ['required', 'in:' . implode(',', User::roleValues())],
            'name' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string', 'max:191'],
        ]);

        SsoRoleOverride::updateOrCreate(
            ['nip' => $data['nip']],
            [
                'role'       => $data['role'],
                'name'       => $data['name'] ?? null,
                'note'       => $data['note'] ?? null,
                'created_by' => Auth::id(),
            ]
        );

        // Sinkronkan role user existing dengan NIP yang sama.
        User::where('nip', $data['nip'])->update(['role' => $data['role']]);

        return redirect()
            ->route('settings.sso-roles.index')
            ->with('success', 'Mapping role berhasil disimpan.');
    }

    public function update(Request $request, SsoRoleOverride $ssoRole)
    {
        $data = $request->validate([
            'role' => ['required', 'in:' . implode(',', User::roleValues())],
            'name' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string', 'max:191'],
        ]);

        $ssoRole->update($data);

        User::where('nip', $ssoRole->nip)->update(['role' => $ssoRole->role]);

        return redirect()
            ->route('settings.sso-roles.index')
            ->with('success', 'Mapping role berhasil diperbarui.');
    }

    public function destroy(SsoRoleOverride $ssoRole)
    {
        $nip = $ssoRole->nip;
        $ssoRole->delete();

        // Reset ke role default agar tidak meninggalkan privilege yang tidak dimaksud.
        $defaultRole = config('sso.default_role', User::ROLE_PEMINJAM);
        User::where('nip', $nip)->update(['role' => $defaultRole]);

        return redirect()
            ->route('settings.sso-roles.index')
            ->with('success', 'Mapping role dihapus. User dikembalikan ke role default.');
    }
}
