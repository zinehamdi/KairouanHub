<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/** Seed services linked to categories — خدمات مرتبطة بالفئات */
class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'plumbing' => [
                'Leak Fix', 'Pipe Installation', 'Bathroom Renovation',
            ],
            'electricity' => [
                'Socket Repair', 'Lighting Installation', 'Fuse Box Upgrade',
            ],
            'air-conditioning' => [
                'AC Installation', 'AC Gas Refill', 'AC Maintenance',
            ],
            'moving' => [
                'Local Moving', 'Packing Service', 'Furniture Assembly',
            ],
            'carpentry' => [
                'Custom Shelves', 'Door Repair',
            ],
            'painter' => [
                'Interior Painting', 'Exterior Painting',
            ],
            'car-wash-mobile' => [
                'Exterior Wash', 'Full Detailing',
            ],
            'photographer' => [
                'Event Photography', 'Portrait Session',
            ],
            'wedding-services' => [
                'Wedding Planning', 'Decoration Setup',
            ],
            'olive-harvest' => [
                'Seasonal Picking Team', 'Olive Transport',
            ],
        ];

        foreach ($map as $slug => $services) {
            $category = Category::where('slug', $slug)->first();
            if (!$category) continue;

            foreach ($services as $name) {
                Service::firstOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'category_id' => $category->id,
                        'name' => $name,
                        'summary' => $name.' service',
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
