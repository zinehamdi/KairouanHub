@extends('layouts.app')

@section('content')
<!-- Providers Page Header -->
<div class="relative bg-gradient-to-br from-neutral-light via-kairouan-limestone to-kairouan-beige py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 175, 55, 0.05) 10px, rgba(212, 175, 55, 0.05) 20px), repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(139, 102, 71, 0.03) 10px, rgba(139, 102, 71, 0.03) 20px);"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-brand-dark mb-4">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-DEFAULT to-accent-amber">
                    {{ __('nav.providers') }}
                </span>
            </h1>
            <p class="text-xl text-brand-dark/80 max-w-2xl mx-auto font-medium">
                {{ __('providers.subtitle', ['تواصل مع محترفين موثوقين في القيروان']) ?? 'تواصل مع محترفين موثوقين في القيروان' }}
            </p>
        </div>

        <!-- Search and Filter -->
        <div class="max-w-4xl mx-auto">
            <form method="GET" action="{{ route('providers.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="{{ __('providers.search_placeholder', ['ابحث عن مقدم خدمة...']) ?? 'ابحث عن مقدم خدمة...' }}"
                        class="w-full px-6 py-4 rounded-lg border-2 border-accent-DEFAULT/20 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 text-brand-dark font-medium shadow-lg transition-all duration-300"
                    >
                </div>
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg hover:shadow-gold transition-all duration-300 hover:scale-105 whitespace-nowrap shadow-lg">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    {{ __('buttons.search', ['بحث']) ?? 'بحث' }}
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Providers Grid -->
<div class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block px-6 py-2 bg-accent-DEFAULT/10 rounded-full border-2 border-accent-DEFAULT/30 mb-4">
                <span class="text-accent-DEFAULT font-bold">{{ __('providers.coming_soon', ['قريباً']) ?? 'قريباً' }}</span>
            </div>
            <p class="text-lg text-brand-dark/70 max-w-2xl mx-auto">
                {{ __('providers.coming_soon_desc', ['نعمل على إضافة المزيد من مقدمي الخدمات قريباً. ابقَ على اطلاع!']) ?? 'نعمل على إضافة المزيد من مقدمي الخدمات قريباً. ابقَ على اطلاع!' }}
            </p>
        </div>

        <!-- Preview Provider Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for($i = 1; $i <= 6; $i++)
            <div class="group bg-gradient-to-br from-neutral-light to-white rounded-xl shadow-xl hover:shadow-2xl border-2 border-accent-DEFAULT/20 hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <!-- Provider Avatar -->
                <div class="relative h-48 bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center">
                    <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center shadow-xl">
                        <svg class="w-12 h-12 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <!-- Badge -->
                    <div class="absolute top-4 right-4 px-3 py-1 bg-white rounded-full shadow-lg">
                        <span class="text-xs font-bold text-accent-DEFAULT">{{ __('providers.verified', ['موثق']) ?? 'موثق' }}</span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-2xl font-bold text-brand-dark mb-2 group-hover:text-accent-DEFAULT transition-colors duration-300">
                        {{ __('providers.provider_' . $i, ['مقدم خدمة ' . $i]) ?? 'مقدم خدمة ' . $i }}
                    </h3>
                    <p class="text-accent-DEFAULT font-medium mb-3">
                        {{ __('providers.specialty', ['تخصص']) }} {{ $i }}
                    </p>
                    <p class="text-brand-dark/70 leading-relaxed mb-4">
                        {{ __('providers.bio', ['وصف موجز عن مقدم الخدمة وخبرته']) ?? 'وصف موجز عن مقدم الخدمة وخبرته' }}
                    </p>

                    <!-- Rating -->
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex">
                            @for($j = 1; $j <= 5; $j++)
                            <svg class="w-5 h-5 text-accent-amber" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-brand-dark/70 text-sm font-medium">5.0 ({{ $i * 10 }} {{ __('providers.reviews', ['تقييم']) }})</span>
                    </div>

                    <!-- CTA Button -->
                    <button class="w-full px-6 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg hover:shadow-gold transition-all duration-300 hover:scale-105">
                        {{ __('providers.view_profile', ['عرض الملف الشخصي']) ?? 'عرض الملف الشخصي' }}
                    </button>
                </div>
            </div>
            @endfor
        </div>

        <!-- Become Provider CTA -->
        <div class="mt-16 text-center">
            <div class="inline-block bg-gradient-to-br from-accent-DEFAULT to-accent-amber p-1 rounded-2xl shadow-2xl">
                <div class="bg-white p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold text-brand-dark mb-4">
                        {{ __('providers.join_us', ['هل أنت مقدم خدمة؟']) ?? 'هل أنت مقدم خدمة؟' }}
                    </h3>
                    <p class="text-brand-dark/70 mb-6 max-w-md mx-auto">
                        {{ __('providers.join_desc', ['انضم إلى شبكتنا من المحترفين واحصل على المزيد من العملاء']) ?? 'انضم إلى شبكتنا من المحترفين واحصل على المزيد من العملاء' }}
                    </p>
                    <a href="{{ route('provider.start') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                        {{ __('providers.become_provider', ['كن مقدم خدمة']) ?? 'كن مقدم خدمة' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
