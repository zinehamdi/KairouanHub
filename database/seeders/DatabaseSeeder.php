<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            SuperAdminSeeder::class,
            ComprehensiveCategorySeeder::class,
            ComprehensiveServiceSeeder::class,
        ]);

        // Optionally seed a couple of normal users
        User::factory()->count(2)->create();
    }
}
