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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');

            $table->date('created_date');
            $table->date('expiry_date')->nullable();

            // Your snippet: Clean, modern foreign key definitions
            $table->foreignId('created_by')->constrained('users');

            // Note: You might want to chain ->nullable() here if a record
            // hasn't been updated yet when it's first created.
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
