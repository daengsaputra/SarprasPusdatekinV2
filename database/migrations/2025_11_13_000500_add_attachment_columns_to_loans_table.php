<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('request_photo_path')->nullable()->after('notes');
            $table->string('loan_photo_path')->nullable()->after('request_photo_path');
            $table->string('return_photo_path')->nullable()->after('loan_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['request_photo_path', 'loan_photo_path', 'return_photo_path']);
        });
    }
};
