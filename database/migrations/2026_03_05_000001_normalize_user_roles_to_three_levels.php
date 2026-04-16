<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => 'super_admin']);
        DB::table('users')->where('role', 'pegawai')->update(['role' => 'peminjam']);
        DB::table('users')->whereNull('role')->update(['role' => 'peminjam']);
        DB::table('users')->where('role', '')->update(['role' => 'peminjam']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);
        DB::table('users')->where('role', 'peminjam')->update(['role' => 'pegawai']);
    }
};
