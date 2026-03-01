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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('subject');
            $table->text('message');
            $table->integer('rating')->nullable();
            $table->string('status')->default('Pending');

            $table->timestamp('created_at')->useCurrent();

            
            $table->foreign('user_id')
                  ->references('UserID')
                  ->on('user_accounts')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
