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
        Schema::create('linked_google_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('provider_id');
            $table->string('provider_name');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['provider_name', 'provider_id'], 'linked_google_accounts_provider_unique');
            $table->unique(['user_id', 'provider_name'], 'linked_google_accounts_user_provider_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linked_google_accounts');
    }
};
