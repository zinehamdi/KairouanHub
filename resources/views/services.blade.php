@extends('layouts.app')

@section('content')
@extends('layouts.app')

@section('content')
<!-- Header Section with SEO -->
<div class="relative bg-gradient-to-br from-kairouan-limestone via-white to-kairouan-beige py-16 overflow-hidden">
    <!-- Subtle Pattern Overlay -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 175, 55, 0.1) 10px, rgba(212, 175, 55, 0.1) 20px);"></div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-brand-dark mb-4">
                {{ __('services.title', ['خدمات القيروان']) ?? 'خدمات القيروان' }}
            </h1>
            <p class="text-lg md:text-xl text-brand-dark/80 max-w-2xl mx-auto">
                {{ __('services.subtitle', ['اكتشف خدمات احترافية من حرفيين محليين - سباكة، كهرباء، تكييف، نقل أثاث وأكثر']) ?? 'اكتشف خدمات احترافية من حرفيين محليين - سباكة، كهرباء، تكييف، نقل أثاث وأكثر' }}
            </p>
        </div>

        <!-- Search and Filter -->
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('services.index') }}" method="GET" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-3">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="q"
                            value="{{ request('q') }}"
                            class="w-full px-6 py-4 bg-white rounded-lg border-2 border-accent-DEFAULT/20 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 text-brand-dark placeholder:text-neutral-DEFAULT/60 font-medium shadow-lg transition-all duration-300"
                            placeholder="{{ __('services.search_placeholder', ['ابحث عن خدمة: سباكة، كهرباء، تكييف...']) ?? 'ابحث عن خدمة: سباكة، كهرباء، تكييف...' }}"
                        />
                    </div>
                    
                    <!-- Category Filter -->
                    @if($categories->count() > 0)
                    <div class="w-full md:w-64">
                        <select 
                            name="category" 
                            class="w-full px-6 py-4 bg-white rounded-lg border-2 border-accent-DEFAULT/20 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 text-brand-dark font-medium shadow-lg transition-all duration-300"
                        >
                            <option value="">{{ __('services.all_categories', ['كل الفئات']) ?? 'كل الفئات' }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    <!-- Search Button -->
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg hover:shadow-gold transition-all duration-300 hover:scale-105 whitespace-nowrap shadow-lg">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        {{ __('services.search', ['بحث']) ?? 'بحث' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Services Grid Section -->
<div class="py-16 bg-gradient-to-b from-white to-kairouan-limestone/30">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($services->count() > 0)
            <!-- Services Count -->
            <div class="mb-8 text-center">
                <p class="text-brand-dark/70 font-medium">
                    {{ __('services.showing_results', ['عرض :count خدمة', ['count' => $services->total()]]) ?? 'عرض ' . $services->total() . ' خدمة' }}
                </p>
            </div>

            <!-- Services Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($services as $service)
                <article class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl border-2 border-transparent hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    <!-- Service Icon/Image Header -->
                    <div class="relative h-48 bg-gradient-to-br from-accent-DEFAULT/10 to-accent-amber/10 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 175, 55, 0.2) 10px, rgba(212, 175, 55, 0.2) 20px);"></div>
                        </div>
                        <div class="relative z-10 w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-gold group-hover:scale-110 transition-transform duration-300">
                            @php
                                $icon = match(strtolower($service->category->name ?? 'default')) {
                                    'plumbing', 'سباكة' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
                                    'electrical', 'كهرباء' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                                    'ac', 'تكييف', 'hvac' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>',
                                    'moving', 'نقل', 'نقل أثاث' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                                    default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'
                                };
                            @endphp
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $icon !!}
                            </svg>
                        </div>
                        
                        <!-- Category Badge -->
                        @if($service->category)
                        <div class="absolute top-4 right-4">
                            <span class="inline-block px-4 py-1 bg-white/95 backdrop-blur-sm text-accent-DEFAULT font-bold text-sm rounded-full border-2 border-accent-DEFAULT/30 shadow-lg">
                                {{ $service->category->name }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Service Content -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-brand-dark mb-3 group-hover:text-accent-DEFAULT transition-colors duration-300">
                            {{ $service->name }}
                        </h3>
                        
                        @if($service->description)
                        <p class="text-brand-dark/70 leading-relaxed mb-4 line-clamp-2">
                            {{ Str::limit($service->description, 100) }}
                        </p>
                        @endif

                        <!-- Service Meta -->
                        <div class="flex items-center justify-between pt-4 border-t border-accent-DEFAULT/20">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent-DEFAULT" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <span class="text-accent-DEFAULT font-semibold text-sm">
                                    {{ __('services.available_providers', ['مقدمو خدمات متاحون']) ?? 'مقدمو خدمات متاحون' }}
                                </span>
                            </div>
                            
                            <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center gap-2 text-accent-DEFAULT font-bold hover:text-accent-amber transition-colors duration-300">
                                {{ __('services.view_details', ['عرض التفاصيل']) ?? 'عرض التفاصيل' }}
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $services->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-accent-DEFAULT/10 mb-6">
                    <svg class="w-12 h-12 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-brand-dark mb-4">
                    {{ __('services.no_results', ['لم يتم العثور على خدمات']) ?? 'لم يتم العثور على خدمات' }}
                </h3>
                <p class="text-brand-dark/70 mb-6 max-w-md mx-auto">
                    {{ __('services.no_results_desc', ['جرب البحث بكلمات مختلفة أو تصفح جميع الفئات']) ?? 'جرب البحث بكلمات مختلفة أو تصفح جميع الفئات' }}
                </p>
                <a href="{{ route('services.index') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                    {{ __('services.view_all', ['عرض جميع الخدمات']) ?? 'عرض جميع الخدمات' }}
                </a>
            </div>
        @endif

        <!-- CTA Section -->
        <div class="mt-16 text-center">
            <div class="inline-block bg-white p-8 rounded-2xl shadow-2xl border-2 border-accent-DEFAULT/30 max-w-2xl">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-4 shadow-gold">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-brand-dark mb-4">
                    {{ __('services.need_custom_service', ['بحاجة لخدمة مخصصة؟']) ?? 'بحاجة لخدمة مخصصة؟' }}
                </h3>
                <p class="text-brand-dark/70 mb-6">
                    {{ __('services.custom_request_desc', ['أخبرنا بما تحتاجه وسنجد لك أفضل الحرفيين في القيروان']) ?? 'أخبرنا بما تحتاجه وسنجد لك أفضل الحرفيين في القيروان' }}
                </p>
                <a href="{{ route('requests.create') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                    {{ __('services.request_service', ['اطلب خدمة الآن']) ?? 'اطلب خدمة الآن' }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
