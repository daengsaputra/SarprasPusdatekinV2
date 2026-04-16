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
        DB::statement('ALTER TABLE loans MODIFY request_photo_path TEXT NULL');
        DB::statement('ALTER TABLE loans MODIFY loan_photo_path TEXT NULL');
        DB::statement('ALTER TABLE loans MODIFY return_photo_path TEXT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE loans MODIFY request_photo_path VARCHAR(255) NULL');
        DB::statement('ALTER TABLE loans MODIFY loan_photo_path VARCHAR(255) NULL');
        DB::statement('ALTER TABLE loans MODIFY return_photo_path VARCHAR(255) NULL');
    }
};
