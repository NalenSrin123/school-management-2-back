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
        Schema::create('video_guide_lines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // File Details
            $table->string('file_path');
            $table->string('file_type'); // e.g., 'image/jpeg', 'pdf'

            // Relationships - mapping to 'users' table
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');

            // Metadata
            $table->date('upload_date')->useCurrent();
            $table->string('visibility')->default('public'); // e.g., 'public', 'private', 'internal'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_guide_lines');
    }
};
