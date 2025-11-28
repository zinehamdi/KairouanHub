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

        // Seed sample providers (EN: demo providers; AR: مزودون تجريبيون)
        if (class_exists(\App\Models\Service::class)) {
            $services = \App\Models\Service::query()->inRandomOrder()->take(5)->get();
            if($services->count() > 0) {
                \App\Models\ProviderProfile::factory()->count(5)->approved()->create()->each(function($profile) use ($services) {
                    $attach = [];
                    foreach ($services->random(min(2, $services->count())) as $svc) {
                        $attach[$svc->id] = ['price_min' => rand(20,80), 'price_max' => rand(90,200)];
                    }
                    $profile->services()->attach($attach);
                });
            }
        }
    }
}
