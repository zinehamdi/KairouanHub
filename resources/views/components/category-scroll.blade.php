@props([
    'categories' => collect()
])

@php
    $gradients = [
        'from-amber-400 to-orange-500',
        'from-emerald-400 to-teal-500', 
        'from-blue-400 to-indigo-500',
        'from-rose-400 to-pink-500',
        'from-violet-400 to-purple-500',
        'from-cyan-400 to-blue-500',
    ];
@endphp

<div class="category-scroll relative">
    {{-- Gradient fade left --}}
    <div class="absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-gray-100 via-gray-50/80 to-transparent z-10 pointer-events-none rtl:hidden"></div>
    <div class="absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-gray-100 via-gray-50/80 to-transparent z-10 pointer-events-none ltr:hidden"></div>
    
    {{-- Scrollable container --}}
    <div class="flex gap-4 overflow-x-auto pb-4 pt-2 px-1 scroll-smooth snap-x snap-mandatory hide-scrollbar" 
         style="-webkit-overflow-scrolling: touch;">
        @foreach($categories as $index => $category)
            <a href="{{ route('services.index', ['category' => $category->slug]) }}" 
               class="category-card group flex-shrink-0 snap-center">
                <div class="w-32 h-40 rounded-2xl bg-gradient-to-br {{ $gradients[$index % count($gradients)] }} p-4 flex flex-col items-center justify-center text-center shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                    {{-- Icon --}}
                    <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        @if($category->icon)
                            @if(strlen($category->icon) <= 10 && !str_contains($category->icon, '.'))
                                {{-- It's likely an emoji or short text --}}
                                <span class="text-2xl">{{ $category->icon }}</span>
                            @else
                                {{-- It's a file path --}}
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="" class="w-6 h-6 object-contain">
                            @endif
                        @else
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        @endif
                    </div>
                    
                    {{-- Name --}}
                    <span class="text-white font-bold text-sm leading-tight line-clamp-2">
                        {{ $category->localized_name }}
                    </span>
                    
                    {{-- Service count badge --}}
                    @if($category->services_count ?? false)
                    <span class="mt-2 px-2 py-0.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs">
                        {{ $category->services_count }} {{ __('services.services') }}
                    </span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
    
    {{-- Gradient fade right --}}
    <div class="absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-gray-100 via-gray-50/80 to-transparent z-10 pointer-events-none rtl:hidden"></div>
    <div class="absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-gray-100 via-gray-50/80 to-transparent z-10 pointer-events-none ltr:hidden"></div>
</div>

<style>
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
