@props([
    'provider' => null
])

@if($provider)
<a href="{{ route('providers.show', $provider) }}" 
   class="provider-card-compact group block bg-white rounded-xl p-4 shadow-md hover:shadow-xl border-2 border-gray-100 hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-0.5">
    <div class="flex items-center gap-3">
        {{-- Avatar --}}
        <div class="flex-shrink-0 relative">
            <div class="w-14 h-14 rounded-full overflow-hidden">
                @if($provider->avatar)
                    <img src="{{ $provider->avatar_url }}" alt="{{ $provider->display_name }}" class="w-full h-full object-cover">
                @else
                    <x-default-avatar size="md" :name="$provider->display_name" />
                @endif
            </div>
            {{-- Trust badge --}}
            @if($provider->status === 'approved')
            <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-green-500 border-2 border-white flex items-center justify-center">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            @endif
        </div>
        
        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <h4 class="font-bold text-brand-dark group-hover:text-accent-DEFAULT transition-colors duration-300 truncate">
                {{ $provider->display_name }}
            </h4>
            
            {{-- Category --}}
            @if($provider->category)
            <p class="text-sm text-gray-500 truncate">
                {{ $provider->category->localized_name ?? $provider->category->name }}
            </p>
            @endif
            
            {{-- Rating & Jobs --}}
            <div class="flex items-center gap-3 mt-1">
                @if($provider->avg_rating)
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ number_format($provider->avg_rating, 1) }}</span>
                </div>
                @else
                <span class="text-xs bg-accent-DEFAULT/10 text-accent-DEFAULT px-2 py-0.5 rounded-full">
                    {{ __('home.no_rating') }}
                </span>
                @endif
                
                @if($provider->completed_jobs > 0)
                <span class="text-xs text-gray-400">
                    {{ $provider->completed_jobs }} {{ __('home.jobs_done') }}
                </span>
                @endif
            </div>
        </div>
        
        {{-- Action arrow --}}
        <div class="flex-shrink-0">
            <div class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-accent-DEFAULT flex items-center justify-center transition-all duration-300">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-white rtl:rotate-180 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </div>
    
    {{-- Location if available --}}
    @if($provider->city)
    <div class="mt-3 flex items-center gap-1 text-xs text-gray-400">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
        </svg>
        <span>{{ $provider->city }}</span>
    </div>
    @endif
</a>
@endif
