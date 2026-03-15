@props([
    'category' => null,
    'class' => '',
])

@php
    $categorySlug = strtolower($category->slug ?? ($category ? $category : 'default'));
    $categoryName = strtolower($category->name ?? '');
    
    // Determine category type and assign colors + pattern
    $patterns = [
        'construction' => [
            'color1' => '#E07A5F',
            'color2' => '#F4A261', 
            'pattern' => '<rect x="0" y="0" width="4" height="20" fill="currentColor" opacity="0.1"/><rect x="8" y="5" width="4" height="15" fill="currentColor" opacity="0.08"/><rect x="16" y="2" width="4" height="18" fill="currentColor" opacity="0.1"/>',
            'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        ],
        'plumbing' => [
            'color1' => '#3B82F6',
            'color2' => '#60A5FA',
            'pattern' => '<circle cx="5" cy="5" r="3" fill="currentColor" opacity="0.08"/><circle cx="15" cy="15" r="4" fill="currentColor" opacity="0.06"/><path d="M0 10 Q10 5 20 10" stroke="currentColor" fill="none" opacity="0.1" stroke-width="2"/>',
            'icon' => 'M12 3v18m0-18a3 3 0 013 3v3h-6V6a3 3 0 013-3z M9 12h6v6a3 3 0 11-6 0v-6z',
        ],
        'electrical' => [
            'color1' => '#F59E0B',
            'color2' => '#FBBF24',
            'pattern' => '<path d="M10 0 L12 8 L8 8 L10 16" stroke="currentColor" fill="none" opacity="0.12" stroke-width="2"/><circle cx="3" cy="12" r="1" fill="currentColor" opacity="0.1"/><circle cx="17" cy="4" r="1" fill="currentColor" opacity="0.1"/>',
            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
        ],
        'cleaning' => [
            'color1' => '#10B981',
            'color2' => '#34D399',
            'pattern' => '<circle cx="5" cy="5" r="2" fill="currentColor" opacity="0.1"/><circle cx="15" cy="10" r="3" fill="currentColor" opacity="0.08"/><circle cx="8" cy="15" r="2" fill="currentColor" opacity="0.1"/>',
            'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
        ],
        'health' => [
            'color1' => '#EC4899',
            'color2' => '#F472B6',
            'pattern' => '<path d="M10 2 L10 8 M7 5 L13 5" stroke="currentColor" opacity="0.12" stroke-width="2"/><circle cx="16" cy="14" r="3" fill="currentColor" opacity="0.06"/>',
            'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
        ],
        'food' => [
            'color1' => '#22C55E',
            'color2' => '#4ADE80',
            'pattern' => '<circle cx="5" cy="10" r="4" fill="currentColor" opacity="0.08"/><circle cx="15" cy="5" r="3" fill="currentColor" opacity="0.06"/><circle cx="12" cy="15" r="2" fill="currentColor" opacity="0.1"/>',
            'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
        ],
        'beauty' => [
            'color1' => '#A855F7',
            'color2' => '#C084FC',
            'pattern' => '<ellipse cx="10" cy="10" rx="6" ry="4" fill="currentColor" opacity="0.06" transform="rotate(45 10 10)"/><circle cx="4" cy="16" r="2" fill="currentColor" opacity="0.08"/>',
            'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
        ],
        'transport' => [
            'color1' => '#F97316',
            'color2' => '#FB923C',
            'pattern' => '<rect x="2" y="8" width="16" height="8" rx="2" fill="currentColor" opacity="0.06"/><circle cx="6" cy="16" r="2" fill="currentColor" opacity="0.1"/><circle cx="14" cy="16" r="2" fill="currentColor" opacity="0.1"/>',
            'icon' => 'M8 17h8M8 17a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 104 0 2 2 0 00-4 0zM3 9h18l-2-6H5L3 9z',
        ],
        'legal' => [
            'color1' => '#6366F1',
            'color2' => '#818CF8',
            'pattern' => '<rect x="4" y="2" width="12" height="16" fill="currentColor" opacity="0.05"/><line x1="6" y1="6" x2="14" y2="6" stroke="currentColor" opacity="0.1" stroke-width="1"/><line x1="6" y1="10" x2="14" y2="10" stroke="currentColor" opacity="0.1" stroke-width="1"/>',
            'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
        ],
        'education' => [
            'color1' => '#14B8A6',
            'color2' => '#2DD4BF',
            'pattern' => '<rect x="3" y="5" width="8" height="10" fill="currentColor" opacity="0.06"/><rect x="12" y="3" width="6" height="12" fill="currentColor" opacity="0.05"/>',
            'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
        ],
        'default' => [
            'color1' => '#D4AF37',
            'color2' => '#E8B545',
            'pattern' => '<circle cx="10" cy="10" r="8" fill="currentColor" opacity="0.05"/><circle cx="10" cy="10" r="4" fill="currentColor" opacity="0.05"/>',
            'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
    ];
    
    // Match category to pattern
    $patternKey = 'default';
    foreach ($patterns as $key => $val) {
        if (str_contains($categorySlug, $key) || str_contains($categoryName, $key)) {
            $patternKey = $key;
            break;
        }
    }
    
    // Additional keyword matching
    $keywordMap = [
        'بناء' => 'construction', 'مقاولات' => 'construction', 'building' => 'construction',
        'سباكة' => 'plumbing', 'صحي' => 'plumbing',
        'كهرباء' => 'electrical', 'كهربائي' => 'electrical',
        'تنظيف' => 'cleaning', 'نظافة' => 'cleaning',
        'طبيب' => 'health', 'صيدلية' => 'health', 'عيادة' => 'health', 'صحة' => 'health',
        'مطعم' => 'food', 'بقالة' => 'food', 'سوق' => 'food', 'خضر' => 'food',
        'صالون' => 'beauty', 'حلاق' => 'beauty', 'جمال' => 'beauty',
        'نقل' => 'transport', 'سيارة' => 'transport', 'توصيل' => 'transport',
        'محامي' => 'legal', 'قانون' => 'legal',
        'تعليم' => 'education', 'مدرس' => 'education', 'تدريب' => 'education',
    ];
    
    foreach ($keywordMap as $keyword => $pKey) {
        if (str_contains($categorySlug, $keyword) || str_contains($categoryName, $keyword)) {
            $patternKey = $pKey;
            break;
        }
    }
    
    $pattern = $patterns[$patternKey];
@endphp

<div {{ $attributes->merge(['class' => "relative h-32 overflow-hidden flex items-center justify-center $class"]) }}
     style="background: linear-gradient(135deg, {{ $pattern['color1'] }}15, {{ $pattern['color2'] }}10);">
    
    {{-- SVG Pattern Background --}}
    <svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none">
        <defs>
            <pattern id="pattern-{{ $patternKey }}-{{ rand() }}" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <g style="color: {{ $pattern['color1'] }}">
                    {!! $pattern['pattern'] !!}
                </g>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#pattern-{{ $patternKey }}-{{ rand() }})"/>
    </svg>
    
    {{-- Decorative large icon in background --}}
    <svg class="absolute opacity-5 w-32 h-32" style="color: {{ $pattern['color1'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $pattern['icon'] }}"/>
    </svg>
    
    {{-- Content slot --}}
    <div class="relative z-10">
        {{ $slot }}
    </div>
</div>
