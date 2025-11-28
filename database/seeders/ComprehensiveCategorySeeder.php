<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class ComprehensiveCategorySeeder extends Seeder
{
	public function run()
	{
		$categories = [
			// 1. Construction & Building - البناء والتشييد
			[
				'name' => 'Construction & General Contracting',
				'name_ar' => 'البناء والمقاولات العامة',
				'slug' => 'construction-contracting',
				'description' => 'General contractors, builders, construction managers',
				'icon' => '🏗️'
			],
			[
				'name' => 'Plumbing',
				'name_ar' => 'السباكة',
				'slug' => 'plumbing',
				'description' => 'Plumbers, water heater installation, pipe repair',
				'icon' => '🔧'
			],
			[
				'name' => 'Electrical',
				'name_ar' => 'الكهرباء',
				'slug' => 'electrical',
				'description' => 'Electricians, wiring, electrical repairs',
				'icon' => '⚡'
			],
			[
				'name' => 'Carpentry & Woodwork',
				'name_ar' => 'النجارة والأعمال الخشبية',
				'slug' => 'carpentry',
				'description' => 'Carpenters, furniture makers, wood finishing',
				'icon' => '🪚'
			],
			[
				'name' => 'Painting & Decoration',
				'name_ar' => 'الطلاء والديكور',
				'slug' => 'painting-decoration',
				'description' => 'Painters, interior decorators, wall finishing',
				'icon' => '🎨'
			],
			[
				'name' => 'Masonry & Tiling',
				'name_ar' => 'البناء والبلاط',
				'slug' => 'masonry-tiling',
				'description' => 'Masons, tile installers, stone work',
				'icon' => '🧱'
			],

			// 2. Home Services - خدمات المنزل
			[
				'name' => 'Cleaning Services',
				'name_ar' => 'خدمات التنظيف',
				'slug' => 'cleaning',
				'description' => 'House cleaning, office cleaning, deep cleaning',
				'icon' => '🧹'
			],
			[
				'name' => 'Gardening & Landscaping',
				'name_ar' => 'البستنة وتنسيق الحدائق',
				'slug' => 'gardening',
				'description' => 'Gardeners, landscaping, lawn care',
				'icon' => '🌳'
			],
			[
				'name' => 'Pest Control',
				'name_ar' => 'مكافحة الحشرات',
				'slug' => 'pest-control',
				'description' => 'Pest control, fumigation, rodent control',
				'icon' => '🐛'
			],
			[
				'name' => 'HVAC & Air Conditioning',
				'name_ar' => 'التكييف والتبريد',
				'slug' => 'hvac',
				'description' => 'AC installation, repair, maintenance',
				'icon' => '❄️'
			],

			// 3. Automotive - السيارات
			[
				'name' => 'Auto Repair & Mechanics',
				'name_ar' => 'إصلاح السيارات والميكانيكا',
				'slug' => 'auto-repair',
				'description' => 'Car mechanics, auto repair, maintenance',
				'icon' => '🔧'
			],
			[
				'name' => 'Auto Detailing & Car Wash',
				'name_ar' => 'تنظيف السيارات والتلميع',
				'slug' => 'auto-detailing',
				'description' => 'Car wash, detailing, polishing',
				'icon' => '🚗'
			],

			// 4. Technology & IT - التكنولوجيا
			[
				'name' => 'Web Development',
				'name_ar' => 'تطوير المواقع',
				'slug' => 'web-development',
				'description' => 'Website development, web applications, e-commerce',
				'icon' => '💻'
			],
			[
				'name' => 'Mobile App Development',
				'name_ar' => 'تطوير تطبيقات الجوال',
				'slug' => 'mobile-development',
				'description' => 'iOS, Android app development',
				'icon' => '📱'
			],
			[
				'name' => 'IT Support & Computer Repair',
				'name_ar' => 'دعم تقني وإصلاح الحواسيب',
				'slug' => 'it-support',
				'description' => 'Computer repair, network setup, IT consulting',
				'icon' => '🖥️'
			],
			[
				'name' => 'Graphic Design',
				'name_ar' => 'التصميم الجرافيكي',
				'slug' => 'graphic-design',
				'description' => 'Logo design, branding, visual identity',
				'icon' => '🎨'
			],
			[
				'name' => 'Digital Marketing',
				'name_ar' => 'التسويق الرقمي',
				'slug' => 'digital-marketing',
				'description' => 'SEO, social media, content marketing',
				'icon' => '📊'
			],

			// 5. Professional Services - الخدمات المهنية
			[
				'name' => 'Legal Services',
				'name_ar' => 'الخدمات القانونية',
				'slug' => 'legal',
				'description' => 'Lawyers, legal consultation, contracts',
				'icon' => '⚖️'
			],
			[
				'name' => 'Accounting & Bookkeeping',
				'name_ar' => 'المحاسبة ومسك الدفاتر',
				'slug' => 'accounting',
				'description' => 'Accountants, tax preparation, financial consulting',
				'icon' => '💰'
			],
			[
				'name' => 'Business Consulting',
				'name_ar' => 'الاستشارات التجارية',
				'slug' => 'business-consulting',
				'description' => 'Business strategy, management consulting',
				'icon' => '💼'
			],
			[
				'name' => 'Translation & Interpretation',
				'name_ar' => 'الترجمة والترجمة الفورية',
				'slug' => 'translation',
				'description' => 'Translation services, interpretation',
				'icon' => '🌍'
			],

			// 6. Healthcare & Wellness - الصحة والعافية
			[
				'name' => 'Medical Consultation',
				'name_ar' => 'الاستشارات الطبية',
				'slug' => 'medical',
				'description' => 'Doctors, medical consultations',
				'icon' => '👨‍⚕️'
			],
			[
				'name' => 'Nursing & Home Care',
				'name_ar' => 'التمريض والرعاية المنزلية',
				'slug' => 'nursing',
				'description' => 'Nurses, elderly care, home healthcare',
				'icon' => '💉'
			],
			[
				'name' => 'Physical Therapy',
				'name_ar' => 'العلاج الطبيعي',
				'slug' => 'physical-therapy',
				'description' => 'Physiotherapists, rehabilitation',
				'icon' => '🏥'
			],
			[
				'name' => 'Nutrition & Dietetics',
				'name_ar' => 'التغذية والحميات',
				'slug' => 'nutrition',
				'description' => 'Nutritionists, diet planning, meal prep',
				'icon' => '🥗'
			],
			[
				'name' => 'Personal Training & Fitness',
				'name_ar' => 'التدريب الشخصي واللياقة',
				'slug' => 'fitness',
				'description' => 'Personal trainers, fitness coaching',
				'icon' => '💪'
			],

			// 7. Education & Training - التعليم والتدريب
			[
				'name' => 'Private Tutoring',
				'name_ar' => 'الدروس الخصوصية',
				'slug' => 'tutoring',
				'description' => 'Academic tutoring, homework help',
				'icon' => '📚'
			],
			[
				'name' => 'Language Teaching',
				'name_ar' => 'تعليم اللغات',
				'slug' => 'language-teaching',
				'description' => 'Language courses, conversation practice',
				'icon' => '🗣️'
			],
			[
				'name' => 'Music & Arts Education',
				'name_ar' => 'تعليم الموسيقى والفنون',
				'slug' => 'music-arts',
				'description' => 'Music lessons, art classes, instrument teaching',
				'icon' => '🎵'
			],
			[
				'name' => 'Professional Training',
				'name_ar' => 'التدريب المهني',
				'slug' => 'professional-training',
				'description' => 'Skills training, workshops, certifications',
				'icon' => '🎓'
			],

			// 8. Events & Entertainment - الفعاليات والترفيه
			[
				'name' => 'Photography',
				'name_ar' => 'التصوير الفوتوغرافي',
				'slug' => 'photography',
				'description' => 'Event photography, portraits, commercial',
				'icon' => '📸'
			],
			[
				'name' => 'Videography',
				'name_ar' => 'التصوير بالفيديو',
				'slug' => 'videography',
				'description' => 'Video production, event filming, editing',
				'icon' => '🎥'
			],
			[
				'name' => 'Event Planning',
				'name_ar' => 'تنظيم الفعاليات',
				'slug' => 'event-planning',
				'description' => 'Wedding planning, corporate events, parties',
				'icon' => '🎉'
			],
			[
				'name' => 'Catering',
				'name_ar' => 'خدمات الطعام',
				'slug' => 'catering',
				'description' => 'Event catering, meal preparation, food service',
				'icon' => '🍽️'
			],
			[
				'name' => 'DJ & Entertainment',
				'name_ar' => 'دي جي والترفيه',
				'slug' => 'dj-entertainment',
				'description' => 'DJs, musicians, entertainers',
				'icon' => '🎧'
			],

			// 9. Beauty & Personal Care - الجمال والعناية الشخصية
			[
				'name' => 'Hair Styling & Barbering',
				'name_ar' => 'تصفيف الشعر والحلاقة',
				'slug' => 'hair-styling',
				'description' => 'Hairstylists, barbers, hair treatments',
				'icon' => '✂️'
			],
			[
				'name' => 'Makeup & Beauty Services',
				'name_ar' => 'المكياج وخدمات التجميل',
				'slug' => 'makeup',
				'description' => 'Makeup artists, beauty treatments, skincare',
				'icon' => '💄'
			],
			[
				'name' => 'Spa & Massage',
				'name_ar' => 'السبا والمساج',
				'slug' => 'spa-massage',
				'description' => 'Massage therapy, spa treatments, wellness',
				'icon' => '💆'
			],

			// 10. Transportation & Logistics - النقل والخدمات اللوجستية
			[
				'name' => 'Moving & Relocation',
				'name_ar' => 'النقل والانتقال',
				'slug' => 'moving',
				'description' => 'Moving services, furniture transport',
				'icon' => '📦'
			],
			[
				'name' => 'Delivery Services',
				'name_ar' => 'خدمات التوصيل',
				'slug' => 'delivery',
				'description' => 'Package delivery, courier services',
				'icon' => '🚚'
			],
			[
				'name' => 'Driver Services',
				'name_ar' => 'خدمات السائقين',
				'slug' => 'driver-services',
				'description' => 'Personal drivers, transportation services',
				'icon' => '🚗'
			],

			// 11. Other Professional Services - خدمات مهنية أخرى
			[
				'name' => 'Real Estate Services',
				'name_ar' => 'خدمات العقارات',
				'slug' => 'real-estate',
				'description' => 'Real estate agents, property management',
				'icon' => '🏠'
			],
			[
				'name' => 'Insurance Services',
				'name_ar' => 'خدمات التأمين',
				'slug' => 'insurance',
				'description' => 'Insurance agents, policy consultation',
				'icon' => '🛡️'
			],
			[
				'name' => 'Security Services',
				'name_ar' => 'خدمات الأمن',
				'slug' => 'security',
				'description' => 'Security guards, surveillance, safety',
				'icon' => '🔒'
			],
			[
				'name' => 'Pet Care & Veterinary',
				'name_ar' => 'رعاية الحيوانات الأليفة',
				'slug' => 'pet-care',
				'description' => 'Pet grooming, veterinary services, pet sitting',
				'icon' => '🐾'
			],

			// 12. Food & Beverage Services - خدمات الطعام والمشروبات
			[
				'name' => 'Restaurant & Cafe Services',
				'name_ar' => 'مطاعم ومقاهي',
				'slug' => 'restaurant-cafe',
				'description' => 'Restaurants, cafes, coffee shops',
				'icon' => '☕'
			],
			[
				'name' => 'Fast Food Services',
				'name_ar' => 'مطاعم الوجبات السريعة',
				'slug' => 'fast-food',
				'description' => 'Fast food restaurants, takeaway, delivery',
				'icon' => '🍔'
			],
			[
				'name' => 'Juice & Smoothie Bars',
				'name_ar' => 'محلات العصائر والمشروبات',
				'slug' => 'juice-bars',
				'description' => 'Fresh juice, smoothies, healthy drinks',
				'icon' => '🥤'
			],
			[
				'name' => 'Bakery & Pastry',
				'name_ar' => 'مخابز وحلويات',
				'slug' => 'bakery',
				'description' => 'Bakeries, pastries, desserts',
				'icon' => '🥐'
			],

			// 13. Agriculture & Farming - الزراعة والمنتجات الزراعية
			[
				'name' => 'Agricultural Products',
				'name_ar' => 'المنتجات الزراعية',
				'slug' => 'agriculture-products',
				'description' => 'Fresh produce, organic farming, farm products',
				'icon' => '🌾'
			],
			[
				'name' => 'Livestock & Poultry',
				'name_ar' => 'الثروة الحيوانية والدواجن',
				'slug' => 'livestock',
				'description' => 'Livestock farming, poultry, dairy products',
				'icon' => '🐄'
			],
			[
				'name' => 'Olive Oil & Products',
				'name_ar' => 'زيت الزيتون ومشتقاته',
				'slug' => 'olive-products',
				'description' => 'Olive oil, olive products, traditional pressing',
				'icon' => '🫒'
			],
			[
				'name' => 'Honey & Bee Products',
				'name_ar' => 'العسل ومنتجات النحل',
				'slug' => 'honey-products',
				'description' => 'Natural honey, bee products, beekeeping',
				'icon' => '🍯'
			],
			[
				'name' => 'Traditional Food Products',
				'name_ar' => 'المنتجات الغذائية التقليدية',
				'slug' => 'traditional-food',
				'description' => 'Traditional foods, local specialties, artisanal products',
				'icon' => '🥘'
			],
		];

		foreach ($categories as $categoryData) {
			Category::updateOrCreate(
				['slug' => $categoryData['slug']],
				$categoryData
			);
		}
	}
}
