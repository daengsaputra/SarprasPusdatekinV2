<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sso_role_overrides', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 32)->unique();
            $table->string('role', 32); // super_admin | petugas | peminjam
            $table->string('name')->nullable();
            $table->string('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sso_role_overrides');
    }
};
