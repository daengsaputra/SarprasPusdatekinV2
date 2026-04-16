<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update the admin user (username: daeng, password: 1234)
        $user = User::firstOrCreate(
            ['name' => 'daeng'],
            [
                'email' => 'daeng@example.com',
                'password' => Hash::make('1234'),
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );

        // Ensure password is up to date if user existed
        if (!Hash::check('1234', $user->password)) {
            $user->password = Hash::make('1234');
            $user->role = User::ROLE_SUPER_ADMIN;
            $user->save();
        }

        // Petugas: naufal / 12345
        $u1 = User::firstOrCreate(
            ['name' => 'naufal'],
            [
                'email' => 'naufal@example.com',
                'password' => Hash::make('12345'),
                'role' => User::ROLE_PETUGAS,
            ]
        );
        if (!Hash::check('12345', $u1->password)) {
            $u1->password = Hash::make('12345');
            $u1->role = User::ROLE_PETUGAS;
            $u1->save();
        }

        // Petugas: wahyu / 12345
        $u2 = User::firstOrCreate(
            ['name' => 'wahyu'],
            [
                'email' => 'wahyu@example.com',
                'password' => Hash::make('12345'),
                'role' => User::ROLE_PETUGAS,
            ]
        );
        if (!Hash::check('12345', $u2->password)) {
            $u2->password = Hash::make('12345');
            $u2->role = User::ROLE_PETUGAS;
            $u2->save();
        }

        // Pegawai / peminjam contoh
        $u3 = User::firstOrCreate(
            ['name' => 'pegawai'],
            [
                'email' => 'pegawai@example.com',
                'password' => Hash::make('12345'),
                'role' => User::ROLE_PEMINJAM,
            ]
        );
        if (!Hash::check('12345', $u3->password)) {
            $u3->password = Hash::make('12345');
            $u3->role = User::ROLE_PEMINJAM;
            $u3->save();
        }
    }
}
