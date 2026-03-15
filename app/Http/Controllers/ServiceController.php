<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Public Services Controller — عرض الخدمات */
class ServiceController extends Controller
{
    /**
     * Define major category groups with metadata
     * AR: تعريف مجموعات الفئات الرئيسية مع البيانات الوصفية
     */
    public static function getCategoryGroups(): array
    {
        return [
            'tourism' => [
                'name_ar' => 'سياحة و ترفيه',
                'name_en' => 'Tourism & Leisure',
                'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                'gradient' => 'from-orange-500 to-amber-500',
                'emoji' => '☕',
                'slugs' => ['restaurant-cafe', 'catering', 'dj-entertainment', 'event-planning', 'photography', 'videography', 'music-arts'],
            ],
            'health' => [
                'name_ar' => 'صحة و رعاية',
                'name_en' => 'Health & Care',
                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'gradient' => 'from-rose-500 to-pink-500',
                'emoji' => '🏥',
                'slugs' => ['medical', 'nursing', 'physical-therapy', 'nutrition', 'fitness', 'pet-care'],
            ],
            'food' => [
                'name_ar' => 'تغذية و مواد',
                'name_en' => 'Food & Grocery',
                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                'gradient' => 'from-green-500 to-emerald-500',
                'emoji' => '🛒',
                'slugs' => ['bakery', 'fast-food', 'juice-bars', 'honey-products', 'olive-products', 'traditional-food', 'agriculture-products', 'livestock'],
            ],
            'home' => [
                'name_ar' => 'خدمات منزلية',
                'name_en' => 'Home Services',
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                'gradient' => 'from-blue-500 to-cyan-500',
                'emoji' => '🔧',
                'slugs' => ['cleaning', 'plumbing', 'electrical', 'carpentry', 'masonry-tiling', 'painting-decoration', 'construction-contracting', 'hvac', 'gardening', 'pest-control', 'moving', 'security', 'delivery', 'driver-services', 'auto-repair', 'auto-detailing'],
            ],
            'professional' => [
                'name_ar' => 'خدمات مهنية',
                'name_en' => 'Professional',
                'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'gradient' => 'from-indigo-500 to-purple-500',
                'emoji' => '⚖️',
                'slugs' => ['accounting', 'business-consulting', 'legal', 'insurance', 'real-estate', 'translation', 'digital-marketing', 'graphic-design', 'web-development', 'mobile-development', 'it-support', 'professional-training', 'language-teaching', 'tutoring'],
            ],
            'beauty' => [
                'name_ar' => 'جمال و عناية',
                'name_en' => 'Beauty & Care',
                'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                'gradient' => 'from-fuchsia-500 to-pink-500',
                'emoji' => '💇',
                'slugs' => ['hair-styling', 'makeup', 'spa-massage'],
            ],
        ];
    }

    public function index(Request $request): View
    {
        $q = $request->string('q');
        $categorySlug = $request->string('category');
        $groupKey = $request->string('group');

        // Fetch all data for the interactive browser
        $categories = Category::where('is_active', true)
            ->with(['services' => fn($q) => $q->where('is_active', true)])
            ->orderBy('position')
            ->get();

        $groups = self::getCategoryGroups();

        // Hierarchical data preparation for Alpine.js
        $browserData = collect($groups)->map(function ($group, $key) use ($categories) {
            $groupCategories = $categories->filter(fn($cat) => in_array($cat->slug, $group['slugs']));
            
            return [
                'key' => $key,
                'name' => app()->getLocale() === 'ar' ? $group['name_ar'] : $group['name_en'],
                'emoji' => $group['emoji'],
                'gradient' => $group['gradient'],
                'categories' => $groupCategories->map(fn($cat) => [
                    'id' => $cat->id,
                    'slug' => $cat->slug,
                    'name' => $cat->localized_name,
                    'icon' => $cat->icon,
                    'services' => $cat->services->map(fn($svc) => [
                        'id' => $svc->id,
                        'slug' => $svc->slug,
                        'name' => $svc->localized_name,
                        'summary' => $svc->localized_summary,
                    ])->values(),
                ])->values(),
            ];
        })->values();

        // Simple listing for search/filters if used as a fallback
        $query = Service::query()->where('is_active', true)->with('category');
        
        if ($q->isNotEmpty()) {
            $query->where(function($qb) use ($q) {
                $qb->where('name', 'like', '%'.$q.'%')
                   ->orWhere('name_ar', 'like', '%'.$q.'%');
            });
        }

        $services = $query->paginate(20)->withQueryString();

        return view('services.index', [
            'services' => $services,
            'browserData' => $browserData,
            'groups' => $groups,
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::with('category')->where('slug', $slug)->firstOrFail();
        return view('services.show', compact('service'));
    }
}
