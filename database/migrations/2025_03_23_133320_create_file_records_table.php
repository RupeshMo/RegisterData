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
        Schema::create('file_records', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('record_id')->constrained()->onDelete('cascade'); // Foreign key referencing records table
            $table->string('file_path'); // File path or filename
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_records'); // Drop the table if it exists
    }
};
