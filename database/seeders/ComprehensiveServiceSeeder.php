<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Service;

class ComprehensiveServiceSeeder extends Seeder
{
    public function run()
    {
        // Get all category slugs to IDs mapping
        $categories = Category::pluck('id', 'slug')->toArray();
        
        $services = [
            // Construction & Building Services
            ['category' => 'construction-contracting', 'name' => 'New Construction', 'name_ar' => 'بناء جديد', 'price' => 5000],
            ['category' => 'construction-contracting', 'name' => 'Renovation', 'name_ar' => 'تجديد', 'price' => 3000],
            ['category' => 'construction-contracting', 'name' => 'Extension', 'name_ar' => 'توسعة', 'price' => 4000],
            
            ['category' => 'plumbing', 'name' => 'Plumbing Repair', 'name_ar' => 'إصلاح السباكة', 'price' => 50],
            ['category' => 'plumbing', 'name' => 'Water Heater Installation', 'name_ar' => 'تركيب سخان مياه', 'price' => 150],
            ['category' => 'plumbing', 'name' => 'Pipe Replacement', 'name_ar' => 'استبدال الأنابيب', 'price' => 200],
            
            ['category' => 'electrical', 'name' => 'Electrical Repair', 'name_ar' => 'إصلاح كهرباء', 'price' => 50],
            ['category' => 'electrical', 'name' => 'Wiring Installation', 'name_ar' => 'تركيب أسلاك كهربائية', 'price' => 300],
            ['category' => 'electrical', 'name' => 'Circuit Breaker Replacement', 'name_ar' => 'استبدال قاطع كهربائي', 'price' => 100],
            
            ['category' => 'carpentry', 'name' => 'Custom Furniture', 'name_ar' => 'أثاث مخصص', 'price' => 500],
            ['category' => 'carpentry', 'name' => 'Door Installation', 'name_ar' => 'تركيب أبواب', 'price' => 200],
            ['category' => 'carpentry', 'name' => 'Wood Repair', 'name_ar' => 'إصلاح خشب', 'price' => 100],
            
            ['category' => 'painting-decoration', 'name' => 'Interior Painting', 'name_ar' => 'دهان داخلي', 'price' => 300],
            ['category' => 'painting-decoration', 'name' => 'Exterior Painting', 'name_ar' => 'دهان خارجي', 'price' => 400],
            ['category' => 'painting-decoration', 'name' => 'Wallpaper Installation', 'name_ar' => 'تركيب ورق جدران', 'price' => 200],
            
            ['category' => 'masonry-tiling', 'name' => 'Floor Tiling', 'name_ar' => 'تبليط الأرضيات', 'price' => 500],
            ['category' => 'masonry-tiling', 'name' => 'Wall Tiling', 'name_ar' => 'تبليط الجدران', 'price' => 400],
            ['category' => 'masonry-tiling', 'name' => 'Stone Work', 'name_ar' => 'أعمال حجرية', 'price' => 600],
            
            // Home Services
            ['category' => 'cleaning', 'name' => 'House Cleaning', 'name_ar' => 'تنظيف منزل', 'price' => 50],
            ['category' => 'cleaning', 'name' => 'Deep Cleaning', 'name_ar' => 'تنظيف عميق', 'price' => 100],
            ['category' => 'cleaning', 'name' => 'Office Cleaning', 'name_ar' => 'تنظيف مكتب', 'price' => 75],
            
            ['category' => 'gardening', 'name' => 'Lawn Mowing', 'name_ar' => 'قص العشب', 'price' => 30],
            ['category' => 'gardening', 'name' => 'Garden Design', 'name_ar' => 'تصميم حديقة', 'price' => 500],
            ['category' => 'gardening', 'name' => 'Tree Pruning', 'name_ar' => 'تقليم الأشجار', 'price' => 80],
            
            ['category' => 'pest-control', 'name' => 'Pest Inspection', 'name_ar' => 'فحص الحشرات', 'price' => 50],
            ['category' => 'pest-control', 'name' => 'Fumigation', 'name_ar' => 'تبخير', 'price' => 150],
            ['category' => 'pest-control', 'name' => 'Rodent Control', 'name_ar' => 'مكافحة القوارض', 'price' => 100],
            
            ['category' => 'hvac', 'name' => 'AC Installation', 'name_ar' => 'تركيب مكيف', 'price' => 500],
            ['category' => 'hvac', 'name' => 'AC Repair', 'name_ar' => 'إصلاح مكيف', 'price' => 80],
            ['category' => 'hvac', 'name' => 'AC Maintenance', 'name_ar' => 'صيانة مكيف', 'price' => 50],
            
            // Technology & IT
            ['category' => 'web-development', 'name' => 'Website Development', 'name_ar' => 'تطوير موقع ويب', 'price' => 1000],
            ['category' => 'web-development', 'name' => 'E-commerce Site', 'name_ar' => 'موقع تجاري', 'price' => 2000],
            ['category' => 'web-development', 'name' => 'Website Maintenance', 'name_ar' => 'صيانة موقع', 'price' => 200],
            
            ['category' => 'mobile-development', 'name' => 'iOS App Development', 'name_ar' => 'تطوير تطبيق iOS', 'price' => 3000],
            ['category' => 'mobile-development', 'name' => 'Android App Development', 'name_ar' => 'تطوير تطبيق أندرويد', 'price' => 3000],
            ['category' => 'mobile-development', 'name' => 'Cross-Platform App', 'name_ar' => 'تطبيق متعدد المنصات', 'price' => 4000],
            
            ['category' => 'it-support', 'name' => 'Computer Repair', 'name_ar' => 'إصلاح كمبيوتر', 'price' => 50],
            ['category' => 'it-support', 'name' => 'Network Setup', 'name_ar' => 'إعداد شبكة', 'price' => 200],
            ['category' => 'it-support', 'name' => 'Data Recovery', 'name_ar' => 'استعادة البيانات', 'price' => 150],
            
            ['category' => 'graphic-design', 'name' => 'Logo Design', 'name_ar' => 'تصميم شعار', 'price' => 200],
            ['category' => 'graphic-design', 'name' => 'Branding Package', 'name_ar' => 'حزمة علامة تجارية', 'price' => 500],
            ['category' => 'graphic-design', 'name' => 'Social Media Graphics', 'name_ar' => 'تصميم لوسائل التواصل', 'price' => 100],
            
            ['category' => 'digital-marketing', 'name' => 'SEO Optimization', 'name_ar' => 'تحسين محركات البحث', 'price' => 300],
            ['category' => 'digital-marketing', 'name' => 'Social Media Management', 'name_ar' => 'إدارة وسائل التواصل', 'price' => 400],
            ['category' => 'digital-marketing', 'name' => 'Google Ads Campaign', 'name_ar' => 'حملة إعلانات جوجل', 'price' => 500],
            
            // Professional Services
            ['category' => 'legal', 'name' => 'Legal Consultation', 'name_ar' => 'استشارة قانونية', 'price' => 100],
            ['category' => 'legal', 'name' => 'Contract Review', 'name_ar' => 'مراجعة عقد', 'price' => 200],
            ['category' => 'legal', 'name' => 'Document Preparation', 'name_ar' => 'إعداد مستندات', 'price' => 150],
            
            ['category' => 'accounting', 'name' => 'Tax Preparation', 'name_ar' => 'إعداد الضرائب', 'price' => 150],
            ['category' => 'accounting', 'name' => 'Bookkeeping', 'name_ar' => 'مسك الدفاتر', 'price' => 200],
            ['category' => 'accounting', 'name' => 'Financial Consulting', 'name_ar' => 'استشارات مالية', 'price' => 250],
            
            ['category' => 'translation', 'name' => 'Document Translation', 'name_ar' => 'ترجمة مستندات', 'price' => 50],
            ['category' => 'translation', 'name' => 'Interpretation', 'name_ar' => 'ترجمة فورية', 'price' => 100],
            ['category' => 'translation', 'name' => 'Website Localization', 'name_ar' => 'توطين موقع', 'price' => 300],
            
            // Education & Training
            ['category' => 'tutoring', 'name' => 'Math Tutoring', 'name_ar' => 'دروس رياضيات', 'price' => 30],
            ['category' => 'tutoring', 'name' => 'Science Tutoring', 'name_ar' => 'دروس علوم', 'price' => 30],
            ['category' => 'tutoring', 'name' => 'Exam Preparation', 'name_ar' => 'تحضير امتحانات', 'price' => 50],
            
            ['category' => 'language-teaching', 'name' => 'English Lessons', 'name_ar' => 'دروس إنجليزية', 'price' => 40],
            ['category' => 'language-teaching', 'name' => 'French Lessons', 'name_ar' => 'دروس فرنسية', 'price' => 40],
            ['category' => 'language-teaching', 'name' => 'Arabic Lessons', 'name_ar' => 'دروس عربية', 'price' => 35],
            
            // Events & Entertainment
            ['category' => 'photography', 'name' => 'Event Photography', 'name_ar' => 'تصوير مناسبات', 'price' => 300],
            ['category' => 'photography', 'name' => 'Portrait Photography', 'name_ar' => 'تصوير بورتريه', 'price' => 150],
            ['category' => 'photography', 'name' => 'Product Photography', 'name_ar' => 'تصوير منتجات', 'price' => 200],
            
            ['category' => 'videography', 'name' => 'Event Videography', 'name_ar' => 'تصوير فيديو للمناسبات', 'price' => 500],
            ['category' => 'videography', 'name' => 'Video Editing', 'name_ar' => 'مونتاج فيديو', 'price' => 200],
            ['category' => 'videography', 'name' => 'Commercial Video', 'name_ar' => 'فيديو تجاري', 'price' => 1000],
            
            ['category' => 'event-planning', 'name' => 'Wedding Planning', 'name_ar' => 'تخطيط زفاف', 'price' => 2000],
            ['category' => 'event-planning', 'name' => 'Corporate Event', 'name_ar' => 'مناسبة شركات', 'price' => 1500],
            ['category' => 'event-planning', 'name' => 'Birthday Party', 'name_ar' => 'حفلة عيد ميلاد', 'price' => 500],
            
            ['category' => 'catering', 'name' => 'Event Catering', 'name_ar' => 'تقديم طعام للمناسبات', 'price' => 500],
            ['category' => 'catering', 'name' => 'Meal Prep Service', 'name_ar' => 'خدمة تحضير وجبات', 'price' => 200],
            
            // Beauty & Personal Care
            ['category' => 'hair-styling', 'name' => 'Haircut', 'name_ar' => 'قص شعر', 'price' => 20],
            ['category' => 'hair-styling', 'name' => 'Hair Coloring', 'name_ar' => 'صبغ شعر', 'price' => 50],
            ['category' => 'hair-styling', 'name' => 'Hair Treatment', 'name_ar' => 'علاج شعر', 'price' => 40],
            
            ['category' => 'makeup', 'name' => 'Bridal Makeup', 'name_ar' => 'مكياج عروس', 'price' => 150],
            ['category' => 'makeup', 'name' => 'Event Makeup', 'name_ar' => 'مكياج مناسبات', 'price' => 80],
            ['category' => 'makeup', 'name' => 'Facial Treatment', 'name_ar' => 'عناية بالوجه', 'price' => 60],
            
            // Transportation
            ['category' => 'moving', 'name' => 'Home Moving', 'name_ar' => 'نقل منزل', 'price' => 300],
            ['category' => 'moving', 'name' => 'Furniture Transport', 'name_ar' => 'نقل أثاث', 'price' => 150],
            ['category' => 'moving', 'name' => 'Packing Service', 'name_ar' => 'خدمة تغليف', 'price' => 100],
            
            ['category' => 'delivery', 'name' => 'Package Delivery', 'name_ar' => 'توصيل طرود', 'price' => 20],
            ['category' => 'delivery', 'name' => 'Express Delivery', 'name_ar' => 'توصيل سريع', 'price' => 30],
            ['category' => 'delivery', 'name' => 'Bulk Delivery', 'name_ar' => 'توصيل بالجملة', 'price' => 50],
        ];
        
        foreach ($services as $serviceData) {
            $categorySlug = $serviceData['category'];
            
            if (isset($categories[$categorySlug])) {
                Service::updateOrCreate(
                    [
                        'name' => $serviceData['name'],
                        'category_id' => $categories[$categorySlug]
                    ],
                    [
                        'name_ar' => $serviceData['name_ar'],
                        'slug' => \Illuminate\Support\Str::slug($serviceData['name']),
                        'summary' => $serviceData['name'],
                        'is_active' => true
                    ]
                );
            }
        }
    }
}
