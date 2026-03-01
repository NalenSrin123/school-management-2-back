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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // varchar translates to string
            $table->text('description');

            // Foreign Key Configuration
            // Assuming modern Laravel where referenced IDs are unsigned big integers
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                  ->references('user_id')
                  ->on('user_accounts')
                  ->onDelete('cascade'); // Adjust the onDelete behavior as needed

            $table->date('created_date');
            $table->date('expiry_date')->nullable(); // Made nullable assuming expiry is optional

            $table->string('status');
            $table->string('priority');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
