<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip', 32)->nullable()->unique()->after('id');
            $table->string('username_intra', 64)->nullable()->after('nip');
            $table->string('jabatan')->nullable()->after('username_intra');
            $table->string('unit_kerja')->nullable()->after('jabatan');
            $table->string('photo_url', 1024)->nullable()->after('photo');
            $table->timestamp('last_sso_login_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nip']);
            $table->dropColumn(['nip', 'username_intra', 'jabatan', 'unit_kerja', 'photo_url', 'last_sso_login_at']);
        });
    }
};
