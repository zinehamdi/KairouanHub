@props([
    'title' => null,
    'description' => null,
    'icon' => 'search',
    'action' => null,
    'actionText' => null,
])

@php
    $icons = [
        'search' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
        'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>',
        'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>',
        'sparkles' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>',
    ];
    $iconPath = $icons[$icon] ?? $icons['sparkles'];
@endphp

<div {{ $attributes->merge(['class' => 'text-center py-12 px-6']) }}>
    {{-- Decorative illustration --}}
    <div class="mx-auto mb-6 relative">
        <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-kairouan-limestone to-kairouan-warm-cream flex items-center justify-center">
            <svg class="w-12 h-12 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $iconPath !!}
            </svg>
        </div>
        {{-- Decorative dots --}}
        <div class="absolute -top-2 -right-2 w-4 h-4 rounded-full bg-accent-amber/50 animate-pulse"></div>
        <div class="absolute -bottom-1 -left-3 w-3 h-3 rounded-full bg-accent-DEFAULT/30 animate-pulse" style="animation-delay: 0.5s;"></div>
    </div>
    
    {{-- Title --}}
    @if($title)
        <h3 class="text-2xl font-bold text-brand-dark mb-3">{{ $title }}</h3>
    @endif
    
    {{-- Description --}}
    @if($description)
        <p class="text-gray-500 mb-6 max-w-md mx-auto leading-relaxed">{{ $description }}</p>
    @endif
    
    {{-- Action Button --}}
    @if($action && $actionText)
        <a href="{{ $action }}" class="btn-accent inline-flex items-center gap-2">
            {{ $actionText }}
            <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    @endif
    
    {{ $slot }}
</div>
