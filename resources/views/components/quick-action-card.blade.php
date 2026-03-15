@props([
    'href' => '#',
    'icon' => '',
    'label' => '',
    'description' => '',
    'gradient' => 'from-accent-DEFAULT to-accent-amber',
    'delay' => '0'
])

<a href="{{ $href }}" 
   class="quick-action-card group block bg-white rounded-2xl p-5 shadow-soft hover:shadow-xl border-2 border-transparent hover:border-accent-DEFAULT/30 transition-all duration-300 hover:-translate-y-1"
   style="animation-delay: {{ $delay }}s;">
    <div class="flex items-center gap-4">
        {{-- Icon Container --}}
        <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
            {!! $icon !!}
        </div>
        
        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <h3 class="text-lg font-bold text-brand-dark group-hover:text-accent-DEFAULT transition-colors duration-300 truncate">
                {{ $label }}
            </h3>
            @if($description)
            <p class="text-sm text-gray-500 truncate">
                {{ $description }}
            </p>
            @endif
        </div>
        
        {{-- Arrow --}}
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 group-hover:bg-accent-DEFAULT flex items-center justify-center transition-all duration-300">
            <svg class="w-4 h-4 text-gray-400 group-hover:text-white rtl:rotate-180 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </div>
</a>
