<?php

namespace Database\Seeders;

use App\Models\SsoRoleOverride;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed mapping awal NIP -> role untuk SSO.
     *
     * Catatan:
     * - Login lokal email/password sudah dihapus. User akan otomatis dibuat
     *   di tabel `users` saat pertama kali login via SSO.
     * - Untuk mengubah daftar super_admin / petugas, tambahkan/edit di
     *   /settings/sso-roles atau di seeder ini lalu jalankan ulang.
     */
    public function run(): void
    {
        $mapping = [
            // Super Admin (akses penuh termasuk pengaturan menu admin)
            User::ROLE_SUPER_ADMIN => [
                // ['nip' => '199803122024211001', 'name' => 'Yusuf'],
            ],
            // Admin Sarpras / Petugas
            User::ROLE_PETUGAS => [
                // ['nip' => '198xxxxxxxxxxxxxxx', 'name' => 'Nama Petugas'],
            ],
            // Pegawai biasa tidak perlu di-seed karena sudah default.
        ];

        foreach ($mapping as $role => $entries) {
            foreach ($entries as $entry) {
                SsoRoleOverride::updateOrCreate(
                    ['nip' => $entry['nip']],
                    [
                        'role' => $role,
                        'name' => $entry['name'] ?? null,
                        'note' => 'Seeded',
                    ]
                );

                // Sinkronkan jika user sudah ada
                User::where('nip', $entry['nip'])->update(['role' => $role]);
            }
        }
    }
}
