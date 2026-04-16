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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->string('borrower_name');
            $table->string('borrower_contact')->nullable();
            $table->unsignedInteger('quantity');
            $table->date('loan_date');
            $table->date('return_date_planned')->nullable();
            $table->date('return_date_actual')->nullable();
            $table->string('status')->default('borrowed'); // borrowed | returned
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
