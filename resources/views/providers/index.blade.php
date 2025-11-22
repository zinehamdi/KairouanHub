@extends('layouts.app')

@section('content')
@php
    // Safety check for filters variable
    $filters = $filters ?? [];
@endphp

<!-- Providers Header Section -->
<div class="relative bg-terracotta-gradient py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-white mb-6">
                مقدمو الخدمات
            </h1>
            <p class="text-xl md:text-2xl text-white/95 max-w-3xl mx-auto">
                تواصل مع حرفيين محترفين وموثوقين في القيروان
            </p>
        </div>

        <!-- Advanced Search and Filter -->
        <div class="max-w-5xl mx-auto">
            <form method="GET" action="{{ route('providers.index') }}" class="bg-white rounded-2xl shadow-soft-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-deep-blue mb-2">
                            بحث بالاسم
                        </label>
                        <input 
                            name="q" 
                            type="text" 
                            value="{{ $filters['q'] ?? '' }}" 
                            placeholder="ابحث عن مقدم خدمة..." 
                            class="input-mediterranean"
                        />
                    </div>

                    <!-- City Filter -->
                    <div>
                        <label class="block text-sm font-bold text-deep-blue mb-2">
                            المدينة
                        </label>
                        <input 
                            name="city" 
                            value="{{ $filters['city'] ?? '' }}" 
                            placeholder="القيروان، حفوز..." 
                            class="input-mediterranean"
                        />
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-bold text-deep-blue mb-2">
                            الفئة
                        </label>
                        <input 
                            name="category" 
                            value="{{ $filters['category'] ?? '' }}" 
                            placeholder="سباكة، كهرباء..." 
                            class="input-mediterranean"
                        />
                    </div>

                    <!-- Badge Filter -->
                    <div>
                        <label class="block text-sm font-bold text-deep-blue mb-2">
                            الشارة
                        </label>
                        <select 
                            name="badge" 
                            class="input-mediterranean"
                        >
                            <option value="">جميع الشارات</option>
                            @foreach(['bronze' => '🥉 برونزي', 'silver' => '🥈 فضي', 'gold' => '🥇 ذهبي'] as $value => $label)
                                <option value="{{ $value }}" {{ ($filters['badge'] ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rating Filter -->
                    <div>
                        <label class="block text-sm font-bold text-deep-blue mb-2">
                            الحد الأدنى للتقييم
                        </label>
                        <input 
                            name="rating" 
                            type="number" 
                            step="0.1" 
                            min="0" 
                            max="5"
                            value="{{ $filters['rating'] ?? '' }}" 
                            placeholder="4.5" 
                            class="input-mediterranean"
                        />
                    </div>
                </div>

                <!-- Search Button -->
                <div class="flex justify-end gap-3">
                    @if(array_filter($filters))
                    <a href="{{ route('providers.index') }}" class="btn-outline-mediterranean">
                        مسح الفلاتر
                    </a>
                    @endif
                    <button type="submit" class="btn-mediterranean">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        بحث
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Providers Grid Section -->
<div class="py-20 bg-soft-cream">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($providers->count() > 0)
            <!-- Providers Count Badge -->
            <div class="mb-8 text-center">
                <div class="inline-block px-8 py-4 bg-terracotta-gradient text-white font-bold text-lg rounded-full shadow-soft">
                    👥 {{ $providers->total() }} مقدم خدمة
                </div>
            </div>

            <!-- Providers Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($providers as $provider)
                <article class="card-mediterranean overflow-hidden">
                    <!-- Provider Header -->
                    <div class="relative h-32 bg-mediterranean-gradient">
                        <!-- Badge Level -->
                        @if($provider->badge_level)
                        <div class="absolute top-4 right-4 z-10">
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-white rounded-full shadow-soft font-bold text-sm">
                                @if($provider->badge_level === 'gold')
                                    <span class="text-xl">🥇</span>
                                    <span class="text-terracotta">ذهبي</span>
                                @elseif($provider->badge_level === 'silver')
                                    <span class="text-xl">🥈</span>
                                    <span class="text-gray-400">فضي</span>
                                @else
                                    <span class="text-xl">🥉</span>
                                    <span class="text-orange-600">برونزي</span>
                                @endif
                            </span>
                        </div>
                        @endif

                        <!-- Avatar -->
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                            <div class="w-24 h-24 rounded-full bg-terracotta-gradient flex items-center justify-center shadow-soft border-4 border-white">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Provider Info -->
                    <div class="pt-16 px-6 pb-6 text-center">
                        <h3 class="text-2xl font-bold text-deep-blue mb-2 hover:text-terracotta transition-colors duration-300">
                            {{ $provider->display_name }}
                        </h3>
                        
                        @if($provider->city)
                        <div class="flex items-center justify-center gap-1 text-gray-600 mb-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-medium">{{ $provider->city }}</span>
                        </div>
                        @endif

                        <!-- Rating with Terracotta Stars -->
                        @if($provider->avg_rating)
                        <div class="flex items-center justify-center gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($provider->avg_rating))
                                    <svg class="w-5 h-5 text-terracotta" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-2 text-terracotta font-bold">{{ number_format($provider->avg_rating, 1) }}</span>
                        </div>
                        @endif

                        <!-- View Profile Button -->
                        <a href="{{ route('providers.show', $provider->id) }}" class="btn-mediterranean w-full justify-center inline-flex items-center gap-2">
                            عرض الملف الشخصي
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $providers->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-block p-8 bg-white rounded-2xl shadow-soft">
                    <div class="w-24 h-24 mx-auto mb-6 bg-soft-cream rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-4">
                        لم يتم العثور على مقدمي خدمات
                    </h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        جرب تغيير معايير البحث أو تصفح جميع مقدمي الخدمات
                    </p>
                    <a href="{{ route('providers.index') }}" class="btn-terracotta inline-block">
                        عرض الكل
                    </a>
                </div>
            </div>
        @endif

        <!-- Become Provider CTA -->
        @guest
        <div class="mt-16 text-center">
            <div class="inline-block bg-blue-gradient p-12 rounded-2xl shadow-soft-lg max-w-3xl">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                
                <h3 class="text-3xl font-bold text-white mb-4">
                    هل أنت حرفي محترف؟
                </h3>
                <p class="text-white/95 text-lg mb-6">
                    انضم إلى منصتنا وابدأ في تلقي طلبات من عملاء في القيروان
                </p>
                <a href="{{ route('register') }}" class="px-12 py-5 bg-white text-mediterranean-blue font-bold text-xl rounded-xl shadow-2xl hover:shadow-soft-lg hover:scale-105 transition-all duration-300 inline-block">
                    انضم الآن
                </a>
            </div>
        </div>
        @endguest
    </div>
</div>
@endsection
