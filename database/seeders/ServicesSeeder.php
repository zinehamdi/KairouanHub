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
                ['en' => 'Leak Fix', 'ar' => 'إصلاح التسربات'],
                ['en' => 'Pipe Installation', 'ar' => 'تركيب الأنابيب'],
                ['en' => 'Bathroom Renovation', 'ar' => 'تجديد الحمام'],
            ],
            'electricity' => [
                ['en' => 'Socket Repair', 'ar' => 'إصلاح المقابس'],
                ['en' => 'Lighting Installation', 'ar' => 'تركيب الإضاءة'],
                ['en' => 'Fuse Box Upgrade', 'ar' => 'تحديث صندوق الكهرباء'],
            ],
            'air-conditioning' => [
                ['en' => 'AC Installation', 'ar' => 'تركيب مكيفات'],
                ['en' => 'AC Gas Refill', 'ar' => 'تعبئة غاز المكيف'],
                ['en' => 'AC Maintenance', 'ar' => 'صيانة مكيفات'],
            ],
            'moving' => [
                ['en' => 'Local Moving', 'ar' => 'نقل محلي'],
                ['en' => 'Packing Service', 'ar' => 'خدمة التغليف'],
                ['en' => 'Furniture Assembly', 'ar' => 'تركيب الأثاث'],
            ],
            'carpentry' => [
                ['en' => 'Custom Shelves', 'ar' => 'رفوف مخصصة'],
                ['en' => 'Door Repair', 'ar' => 'إصلاح الأبواب'],
            ],
            'painter' => [
                ['en' => 'Interior Painting', 'ar' => 'دهان داخلي'],
                ['en' => 'Exterior Painting', 'ar' => 'دهان خارجي'],
            ],
            'car-wash-mobile' => [
                ['en' => 'Exterior Wash', 'ar' => 'غسيل خارجي'],
                ['en' => 'Full Detailing', 'ar' => 'تنظيف شامل'],
            ],
            'photographer' => [
                ['en' => 'Event Photography', 'ar' => 'تصوير مناسبات'],
                ['en' => 'Portrait Session', 'ar' => 'جلسة تصوير شخصية'],
            ],
            'wedding-services' => [
                ['en' => 'Wedding Planning', 'ar' => 'تخطيط حفلات الزفاف'],
                ['en' => 'Decoration Setup', 'ar' => 'تجهيز الديكور'],
            ],
            'olive-harvest' => [
                ['en' => 'Seasonal Picking Team', 'ar' => 'فريق جني الزيتون'],
                ['en' => 'Olive Transport', 'ar' => 'نقل الزيتون'],
            ],
        ];

        foreach ($map as $slug => $services) {
            $category = Category::where('slug', $slug)->first();
            if (!$category) continue;

            foreach ($services as $serviceData) {
                Service::firstOrCreate(
                    ['slug' => Str::slug($serviceData['en'])],
                    [
                        'category_id' => $category->id,
                        'name' => $serviceData['en'],
                        'name_ar' => $serviceData['ar'],
                        'summary' => $serviceData['en'].' service',
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
