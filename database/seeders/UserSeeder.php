<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed a few known accounts plus some fake users.
     */
    public function run(): void
    {
        $now = now();

        // Known accounts for local/dev usage.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'role_id' => 1,
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => $now,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'role_id' => 2,
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => $now,
            ]
        );

        // Additional fake users.
        User::factory()
            ->count(8)
            ->create();
    }
}
