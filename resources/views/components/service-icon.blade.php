@props([
    'category' => null,
    'service' => null,
    'size' => 'md',
    'class' => '',
    'iconOnly' => false,
])

@php
    $sizeClasses = ['sm' => 'w-8 h-8', 'md' => 'w-10 h-10', 'lg' => 'w-14 h-14', 'xl' => 'w-20 h-20'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    
    $categorySlug = $category->slug ?? ($category ? strtolower($category) : 'default');
    $serviceName = strtolower($service->name ?? $service ?? '');
    
    // Category colors - Premium Palette
    $colors = [
        'construction' => ['#D4A373', '#A98467'],
        'plumbing' => ['#0077B6', '#00B4D8'],
        'electrical' => ['#FFB703', '#FB8500'],
        'hvac' => ['#8ECAE6', '#219EBC'],
        'carpentry' => ['#606C38', '#283618'],
        'painting' => ['#E76F51', '#F4A261'],
        'cleaning' => ['#2A9D8F', '#264653'],
        'gardening' => ['#52796F', '#354F52'],
        'automotive' => ['#333333', '#000000'],
        'technology' => ['#3F37C9', '#4CC9F0'],
        'development' => ['#7209B7', '#B5179E'],
        'design' => ['#F72585', '#7209B7'],
        'legal' => ['#1D3557', '#457B9D'],
        'healthcare' => ['#E63946', '#F1FAEE'],
        'education' => ['#A8DADC', '#457B9D'],
        'photography' => ['#2B2D42', '#8D99AE'],
        'beauty' => ['#FF99C8', '#FCF6BD'],
        'transport' => ['#FB8B24', '#D90429'],
        'food' => ['#E07A5F', '#3D405B'],
        'agriculture' => ['#81B29A', '#F2CC8F'],
        'security' => ['#242423', '#333533'],
        'real-estate' => ['#ADB5BD', '#495057'],
        'default' => ['#DAA520', '#B8860B'],
    ];
    
    $colorKey = 'default';
    foreach ($colors as $key => $vals) {
        if (str_contains($categorySlug, $key) || str_contains($serviceName, $key)) {
            $colorKey = $key;
            break;
        }
    }
    $color = $colors[$colorKey];
@endphp

@if($iconOnly)
    <svg class="{{ $sizeClass }} {{ $class }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
@else
    <div {{ $attributes->merge(['class' => "$sizeClass flex items-center justify-center rounded-[1.25rem] $class shadow-lg"]) }}
         style="background: linear-gradient(135deg, {{ $color[0] }}, {{ $color[1] }});">
        <svg class="w-1/2 h-1/2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
@endif
        @switch($colorKey)
            @case('plumbing')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.675.27a6 6 0 00-3.86.517l-2.387.477a2 2 0 00-1.022.547M19.428 15.428a2 2 0 00.572-1.428V8.5a2 2 0 00-2-2H6.5a2 2 0 00-2 2v5.5a2 2 0 00.572 1.428M19.428 15.428L20 16m-15.428-1.428L4 16m5-8V6a3 3 0 016 0v2"/>
                @break
            @case('electrical')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                @break
            @case('hvac')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                @break
            @case('cleaning')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                @break
            @case('gardening')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                @break
            @case('automotive')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                @break
            @case('technology')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                @break
            @case('legal')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                @break
            @case('healthcare')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                @break
            @case('education')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                @break
            @case('photography')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                @break
            @case('beauty')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                @break
            @case('transport')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                @break
            @case('food')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                @break
            @case('security')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A3.333 3.333 0 0121 12c0 1.237-.674 2.318-1.67 2.902A3.333 3.333 0 0118 18c-1.237 0-2.318-.674-2.902-1.67A3.333 3.333 0 0112 17c-1.237 0-2.318.674-2.902 1.67A3.333 3.333 0 016 18c-1.237 0-2.318-.674-2.902-1.67A3.333 3.333 0 013 12c0-1.237.674-2.318 1.67-2.902A3.333 3.333 0 016 6c1.237 0 2.318.674 2.902 1.67A3.333 3.333 0 0112 7c1.237 0 2.318-.674 2.902-1.67A3.333 3.333 0 0118 6c1.237 0 2.318.674 2.902 1.67z"/>
                @break
            @case('real-estate')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                @break
            @case('development')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                @break
            @case('design')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                @break
            @case('agriculture')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                @break
            @default
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        @endswitch
    </svg>
@if(!$iconOnly)
</div>
@endif
