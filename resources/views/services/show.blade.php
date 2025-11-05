@extends('layouts.app')

@section('content')
<!-- Service Hero Section -->
<div class="relative bg-gradient-to-br from-kairouan-limestone via-white to-kairouan-beige py-16 overflow-hidden">
    <!-- Pattern Overlay -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 175, 55, 0.1) 10px, rgba(212, 175, 55, 0.1) 20px);"></div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 rtl:space-x-reverse text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-brand-dark/60 hover:text-accent-DEFAULT transition-colors">
                        {{ __('nav.home', ['الرئيسية']) ?? 'الرئيسية' }}
                    </a>
                </li>
                <li class="text-brand-dark/40">/</li>
                <li>
                    <a href="{{ route('services.index') }}" class="text-brand-dark/60 hover:text-accent-DEFAULT transition-colors">
                        {{ __('nav.services', ['الخدمات']) ?? 'الخدمات' }}
                    </a>
                </li>
                <li class="text-brand-dark/40">/</li>
                <li class="text-brand-dark font-semibold">{{ $service->name }}</li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Service Icon -->
            <div class="flex-shrink-0">
                <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-gold">
                    @php
                        $icon = match(strtolower($service->category->name ?? 'default')) {
                            'plumbing', 'سباكة' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
                            'electrical', 'كهرباء' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                            'ac', 'تكييف', 'hvac' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>',
                            'moving', 'نقل', 'نقل أثاث' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                            default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'
                        };
                    @endphp
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $icon !!}
                    </svg>
                </div>
            </div>

            <!-- Service Info -->
            <div class="flex-1">
                @if($service->category)
                <div class="inline-block px-4 py-1 bg-accent-DEFAULT/10 text-accent-DEFAULT font-bold text-sm rounded-full border-2 border-accent-DEFAULT/30 mb-4">
                    {{ $service->category->name }}
                </div>
                @endif
                
                <h1 class="text-4xl md:text-5xl font-heading font-bold text-brand-dark mb-4">
                    {{ $service->name }}
                </h1>
                
                @if($service->summary || $service->description)
                <p class="text-xl text-brand-dark/80 leading-relaxed mb-6">
                    {{ $service->summary ?? $service->description }}
                </p>
                @endif

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-6 mb-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-accent-DEFAULT" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="text-brand-dark font-semibold">
                            {{ __('services.available_providers', ['مقدمو خدمات محترفون']) ?? 'مقدمو خدمات محترفون' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-accent-DEFAULT" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-brand-dark font-semibold">
                            {{ __('services.flexible_schedule', ['جدولة مرنة']) ?? 'جدولة مرنة' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-accent-DEFAULT" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-brand-dark font-semibold">
                            {{ __('services.quality_guaranteed', ['جودة مضمونة']) ?? 'جودة مضمونة' }}
                        </span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('requests.create', ['service' => $service->slug]) }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('services.request_this_service', ['اطلب هذه الخدمة']) ?? 'اطلب هذه الخدمة' }}
                    </a>
                    
                    <a href="{{ route('providers.index', ['service' => $service->slug]) }}" class="inline-flex items-center px-8 py-4 bg-white border-2 border-accent-DEFAULT text-brand-dark font-bold text-lg rounded-lg hover:bg-accent-DEFAULT hover:text-white shadow-lg transition-all duration-300">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        {{ __('services.find_providers', ['ابحث عن مقدمي خدمة']) ?? 'ابحث عن مقدمي خدمة' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Details Section -->
<div class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- What's Included -->
            <div class="bg-gradient-to-br from-kairouan-limestone to-white p-8 rounded-2xl shadow-xl border-2 border-accent-DEFAULT/20 mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-gold">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-brand-dark">
                        {{ __('services.whats_included', ['ما يتضمنه هذه الخدمة']) ?? 'ما يتضمنه هذه الخدمة' }}
                    </h2>
                </div>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent-DEFAULT flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-brand-dark">{{ __('services.feature_1_title', ['محترفون موثوقون']) ?? 'محترفون موثوقون' }}</h4>
                            <p class="text-brand-dark/70">{{ __('services.feature_1_desc', ['جميع مقدمي الخدمات معتمدون وذوو خبرة']) ?? 'جميع مقدمي الخدمات معتمدون وذوو خبرة' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent-DEFAULT flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-brand-dark">{{ __('services.feature_2_title', ['أسعار شفافة']) ?? 'أسعار شفافة' }}</h4>
                            <p class="text-brand-dark/70">{{ __('services.feature_2_desc', ['احصل على عروض أسعار واضحة قبل البدء']) ?? 'احصل على عروض أسعار واضحة قبل البدء' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent-DEFAULT flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-brand-dark">{{ __('services.feature_3_title', ['ضمان الجودة']) ?? 'ضمان الجودة' }}</h4>
                            <p class="text-brand-dark/70">{{ __('services.feature_3_desc', ['نضمن جودة العمل ورضا العملاء']) ?? 'نضمن جودة العمل ورضا العملاء' }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-accent-DEFAULT flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-brand-dark">{{ __('services.feature_4_title', ['دعم محلي']) ?? 'دعم محلي' }}</h4>
                            <p class="text-brand-dark/70">{{ __('services.feature_4_desc', ['خدمة عملاء متاحة لمساعدتك في أي وقت']) ?? 'خدمة عملاء متاحة لمساعدتك في أي وقت' }}</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- How It Works -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-brand-dark mb-8 text-center">
                    {{ __('services.how_it_works', ['كيف يعمل']) ?? 'كيف يعمل' }}
                </h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white text-2xl font-bold mb-4 shadow-gold">
                            1
                        </div>
                        <h3 class="text-xl font-bold text-brand-dark mb-2">
                            {{ __('services.step_1_title', ['اطلب الخدمة']) ?? 'اطلب الخدمة' }}
                        </h3>
                        <p class="text-brand-dark/70">
                            {{ __('services.step_1_desc', ['أخبرنا بما تحتاجه ومتى']) ?? 'أخبرنا بما تحتاجه ومتى' }}
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white text-2xl font-bold mb-4 shadow-gold">
                            2
                        </div>
                        <h3 class="text-xl font-bold text-brand-dark mb-2">
                            {{ __('services.step_2_title', ['احصل على عروض']) ?? 'احصل على عروض' }}
                        </h3>
                        <p class="text-brand-dark/70">
                            {{ __('services.step_2_desc', ['مقدمو الخدمات يرسلون عروضهم']) ?? 'مقدمو الخدمات يرسلون عروضهم' }}
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white text-2xl font-bold mb-4 shadow-gold">
                            3
                        </div>
                        <h3 class="text-xl font-bold text-brand-dark mb-2">
                            {{ __('services.step_3_title', ['اختر الأفضل']) ?? 'اختر الأفضل' }}
                        </h3>
                        <p class="text-brand-dark/70">
                            {{ __('services.step_3_desc', ['قارن واختر مقدم الخدمة المناسب']) ?? 'قارن واختر مقدم الخدمة المناسب' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Final CTA -->
            <div class="text-center bg-gradient-to-br from-accent-DEFAULT to-accent-amber p-12 rounded-2xl shadow-2xl">
                <h2 class="text-3xl font-bold text-white mb-4">
                    {{ __('services.ready_to_start', ['جاهز للبدء؟']) ?? 'جاهز للبدء؟' }}
                </h2>
                <p class="text-white/90 text-lg mb-6 max-w-2xl mx-auto">
                    {{ __('services.cta_desc', ['احصل على خدمة احترافية من أفضل الحرفيين في القيروان']) ?? 'احصل على خدمة احترافية من أفضل الحرفيين في القيروان' }}
                </p>
                <a href="{{ route('requests.create', ['service' => $service->slug]) }}" class="inline-block px-10 py-5 bg-white text-accent-DEFAULT font-bold text-xl rounded-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    {{ __('services.request_now', ['اطلب الآن']) ?? 'اطلب الآن' }}
                </a>
            </div>
        </div>
    </div>
</div>

@if($service->category && $service->category->services->count() > 1)
<!-- Related Services -->
<div class="py-16 bg-gradient-to-b from-kairouan-limestone/30 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-brand-dark mb-8 text-center">
            {{ __('services.related_services', ['خدمات مشابهة']) ?? 'خدمات مشابهة' }}
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($service->category->services->where('id', '!=', $service->id)->take(3) as $relatedService)
            <a href="{{ route('services.show', $relatedService->slug) }}" class="group bg-white p-6 rounded-xl shadow-xl hover:shadow-2xl border-2 border-transparent hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-brand-dark mb-2 group-hover:text-accent-DEFAULT transition-colors duration-300">
                    {{ $relatedService->name }}
                </h3>
                @if($relatedService->summary)
                <p class="text-brand-dark/70 text-sm line-clamp-2">
                    {{ Str::limit($relatedService->summary, 80) }}
                </p>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
