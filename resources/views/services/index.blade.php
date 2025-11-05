@extends('layouts.app')

@section('content')
<!-- Services Hero Section with Vibrant Gradient -->
<div class="relative bg-gradient-to-br from-accent-amber via-accent-DEFAULT to-kairouan-brown py-20 overflow-hidden">
    <!-- Animated Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 animate-pulse" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 15px, rgba(255, 255, 255, 0.3) 15px, rgba(255, 255, 255, 0.3) 30px);"></div>
    </div>
    
    <!-- Floating Circles for Life -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl animate-bounce"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-pulse"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-10">
            <h1 class="text-5xl md:text-6xl font-heading font-bold text-white mb-6 drop-shadow-2xl">
                خدماتنا المميزة في القيروان
            </h1>
            <p class="text-xl md:text-2xl text-white/95 max-w-3xl mx-auto drop-shadow-lg font-medium">
                نقدم لك مجموعة شاملة من الخدمات الاحترافية لجعل حياتك أسهل وأكثر راحة
            </p>
            <div class="mt-8 flex justify-center gap-3">
                <div class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-white font-bold border-2 border-white/40">
                    ✨ جودة عالية
                </div>
                <div class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-white font-bold border-2 border-white/40">
                    🔧 حرفيون محترفون
                </div>
                <div class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-white font-bold border-2 border-white/40">
                    ⚡ خدمة سريعة
                </div>
            </div>
        </div>

        <!-- Search and Filter Form with Vibrant Design -->
        <div class="max-w-4xl mx-auto">
            <form method="GET" action="{{ route('services.index') }}" class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border-2 border-white/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}" 
                                placeholder="ابحث عن الخدمة التي تحتاجها..." 
                                class="w-full px-6 py-4 pr-12 rounded-2xl border-3 border-accent-DEFAULT/30 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 text-brand-dark font-medium text-lg transition-all duration-300 shadow-lg"
                            />
                        </div>
                    </div>
                    
                    <!-- Category Select -->
                    <div>
                        <select 
                            name="category" 
                            class="w-full px-6 py-4 rounded-2xl border-3 border-accent-DEFAULT/30 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 text-brand-dark font-medium transition-all duration-300 shadow-lg appearance-none bg-white"
                        >
                            <option value="">جميع الفئات 🏷️</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" @selected(request('category')===$cat->slug)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Active Only Checkbox -->
                    <div class="flex items-center">
                        <label class="flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-accent-DEFAULT/10 to-accent-amber/10 rounded-2xl cursor-pointer hover:from-accent-DEFAULT/20 hover:to-accent-amber/20 transition-all duration-300 w-full shadow-lg">
                            <input 
                                type="checkbox" 
                                name="active" 
                                value="1" 
                                @checked(request()->boolean('active', true)) 
                                class="w-5 h-5 text-accent-DEFAULT rounded focus:ring-accent-DEFAULT focus:ring-2"
                            />
                            <span class="font-bold text-brand-dark">الخدمات النشطة فقط ✓</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="w-full px-8 py-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-xl rounded-2xl hover:shadow-2xl hover:scale-105 transition-all duration-300 shadow-xl">
                    <span class="inline-flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        ابحث الآن
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Services Grid Section with Colorful Cards -->
<div class="py-20 bg-gradient-to-b from-kairouan-limestone via-white to-kairouan-beige">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Services Count Badge -->
        @if($services->total() > 0)
        <div class="text-center mb-12">
            <div class="inline-block px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-full shadow-2xl">
                🎯 {{ $services->total() }} خدمة متاحة
            </div>
        </div>
        @endif

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($services as $service)
                @php
                    // Define vibrant gradient colors for each service type
                    $gradients = [
                        'from-accent-DEFAULT to-accent-amber',
                        'from-accent-amber to-orange-500',
                        'from-accent-DEFAULT to-yellow-500',
                        'from-orange-500 to-accent-DEFAULT',
                        'from-yellow-500 to-accent-amber',
                        'from-accent-amber to-accent-DEFAULT',
                    ];
                    $gradient = $gradients[$loop->index % count($gradients)];
                @endphp
                
                <article class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 overflow-hidden border-2 border-transparent hover:border-accent-DEFAULT/40">
                    <!-- Vibrant Gradient Header -->
                    <div class="relative h-40 bg-gradient-to-br {{ $gradient }} overflow-hidden">
                        <!-- Animated Pattern -->
                        <div class="absolute inset-0 opacity-20">
                            <div class="absolute inset-0 group-hover:animate-pulse" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 255, 255, 0.3) 10px, rgba(255, 255, 255, 0.3) 20px);"></div>
                        </div>
                        
                        <!-- Service Icon with Glow Effect -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-24 h-24 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300 border-4 border-white/50">
                                @if(str_contains(strtolower($service->name), 'سباكة') || str_contains(strtolower($service->name), 'plumb'))
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3v18m0-18a3 3 0 013 3v3h-6V6a3 3 0 013-3z"/>
                                        <path d="M9 12h6v6a3 3 0 11-6 0v-6z"/>
                                    </svg>
                                @elseif(str_contains(strtolower($service->name), 'كهرباء') || str_contains(strtolower($service->name), 'electric'))
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                                    </svg>
                                @elseif(str_contains(strtolower($service->name), 'تكييف') || str_contains(strtolower($service->name), 'ac') || str_contains(strtolower($service->name), 'air'))
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582a1 1 0 01.641.935V14a1 1 0 01-.641.935L11 16.516V18a1 1 0 11-2 0v-1.516l-3.954-1.581A1 1 0 014 14V6.84a1 1 0 01.641-.935L8.954 4.323V3a1 1 0 011-1zM6 7.42v5.16l4 1.599V9.017L6 7.419zm8 5.16V7.42l-4-1.598v5.164l4 1.596z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif(str_contains(strtolower($service->name), 'نقل') || str_contains(strtolower($service->name), 'moving'))
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                @else
                                    <svg class="w-12 h-12 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-2 bg-white/95 backdrop-blur-sm rounded-full text-xs font-bold text-brand-dark shadow-lg">
                                {{ $service->category->name ?? 'خدمة عامة' }}
                            </span>
                        </div>
                    </div>

                    <!-- Service Content -->
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-brand-dark mb-4 group-hover:text-accent-DEFAULT transition-colors duration-300">
                            {{ e($service->name) }}
                        </h3>
                        <p class="text-brand-dark/70 mb-6 leading-relaxed line-clamp-3">
                            {{ e(\Illuminate\Support\Str::limit($service->summary, 120)) }}
                        </p>
                        
                        <!-- Action Button with Gradient -->
                        <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r {{ $gradient }} text-white font-bold rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full justify-center group-hover:gap-4">
                            اكتشف المزيد
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Decorative Corner -->
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br {{ $gradient }} opacity-10 rounded-bl-full"></div>
                </article>
            @empty
                <!-- Empty State with Hope -->
                <div class="col-span-full text-center py-20">
                    <div class="inline-block p-8 bg-gradient-to-br from-accent-DEFAULT to-accent-amber rounded-3xl shadow-2xl">
                        <div class="w-24 h-24 mx-auto mb-6 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-4">لا توجد خدمات متاحة</h3>
                        <p class="text-white/90 text-lg mb-6">جرب تغيير معايير البحث أو تصفح جميع الخدمات</p>
                        <a href="{{ route('services.index') }}" class="inline-block px-10 py-4 bg-white text-accent-DEFAULT font-bold rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                            عرض جميع الخدمات
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
        <div class="mt-12">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Call to Action Section -->
<div class="py-20 bg-gradient-to-r from-accent-amber via-accent-DEFAULT to-kairouan-brown relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 animate-pulse" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255, 255, 255, 0.2) 20px, rgba(255, 255, 255, 0.2) 40px);"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 drop-shadow-2xl">
            🌟 لم تجد ما تبحث عنه؟
        </h2>
        <p class="text-xl text-white/95 mb-8 max-w-2xl mx-auto drop-shadow-lg">
            تواصل معنا مباشرة وسنساعدك في إيجاد الخدمة المثالية لاحتياجاتك
        </p>
        <a href="{{ route('home') }}" class="inline-block px-12 py-5 bg-white text-accent-DEFAULT font-bold text-xl rounded-2xl shadow-2xl hover:shadow-white/50 hover:scale-110 transition-all duration-300">
            تواصل معنا الآن
        </a>
    </div>
</div>
@endsection
