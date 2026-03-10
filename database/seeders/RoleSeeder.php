<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed required roles with stable IDs (referenced by controllers).
     */
    public function run(): void
    {
        $now = now();

        // Keep IDs stable since parts of the app assume specific role IDs.
        $roles = [
            ['id' => 1, 'name' => 'Admin', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'User', 'created_at' => $now, 'updated_at' => $now],
        ];

        // On conflict, only update mutable fields; keep existing created_at intact.
        DB::table('roles')->upsert($roles, ['id'], ['name', 'updated_at']);
    }
}
