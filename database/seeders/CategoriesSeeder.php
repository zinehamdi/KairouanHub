<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/** Seed base categories — فئات أساسية */
class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Plumbing', 'description' => 'Pipes, leaks, and fixtures'],
            ['name' => 'Electricity', 'description' => 'Wiring and electrical fixes'],
            ['name' => 'Air Conditioning', 'description' => 'AC install and repair'],
            ['name' => 'Moving', 'description' => 'House and office relocation'],
            ['name' => 'Carpentry', 'description' => 'Woodwork and furniture'],
            ['name' => 'Painter', 'description' => 'Indoor/outdoor painting'],
            ['name' => 'Car Wash Mobile', 'description' => 'On-site car wash'],
            ['name' => 'Photographer', 'description' => 'Events and portraits'],
            ['name' => 'Wedding Services', 'description' => 'Planning and decoration'],
            ['name' => 'Olive Harvest', 'description' => 'Seasonal harvesting help'],
        ];

        foreach ($items as $i => $data) {
            Category::firstOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'position' => $i,
                    'is_active' => true,
                ]
            );
        }
    }
}
