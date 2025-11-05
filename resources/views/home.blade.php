@extends('layouts.app')

@section('content')
<!-- Hero Section with Kairouan Background - BETTER VISIBILITY -->
<div class="hero-kairouan relative bg-cover bg-center bg-no-repeat min-h-screen flex items-center justify-center" style="background-image: linear-gradient(to bottom, rgba(45, 38, 33, 0.45), rgba(139, 102, 71, 0.40)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <!-- Subtle Pattern Overlay -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 175, 55, 0.1) 10px, rgba(212, 175, 55, 0.1) 20px);"></div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
        <!-- Logo -->
        <div class="mb-8 fade-in">
            <img src="{{ asset('images/kairouanhubLogo.PNG') }}" 
                 alt="KairouanHub Logo" 
                 class="h-32 md:h-40 mx-auto drop-shadow-2xl">
        </div>
        
        <!-- Main Heading with Better Contrast -->
        <h1 class="text-5xl md:text-7xl font-heading font-bold mb-6 leading-tight tracking-tight slide-up drop-shadow-lg">
            <span class="block text-white">
                KairouanHub - منصة الخدمات المحلية
            </span>
        </h1>
        
        <p class="text-2xl md:text-3xl mb-4 font-serif font-bold text-white drop-shadow-md slide-up" style="animation-delay: 0.2s;">
            القيروان، روح التراث ومستقبل التقنية
        </p>
        
        <p class="text-lg md:text-xl mb-8 text-white/90 font-medium drop-shadow-md slide-up" style="animation-delay: 0.3s;">
            Kairouan, the soul of heritage and the future of tech
        </p>

        <!-- Search Bar with Better Contrast -->
        <div class="max-w-3xl mx-auto mb-12 slide-up" style="animation-delay: 0.4s;">
            <form action="{{ route('services.index') }}" method="GET" class="relative">
                <div class="flex items-center gap-3 p-2 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border-2 border-accent-DEFAULT/30 hover:border-accent-DEFAULT/50 transition-all duration-300">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search"
                            class="w-full px-6 py-4 bg-transparent border-0 focus:ring-0 text-brand-dark placeholder:text-neutral-DEFAULT/60 text-lg font-medium"
                            placeholder="ابحث عن خدمة..." 
                        />
                    </div>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold rounded-lg hover:shadow-gold transition-all duration-300 hover:scale-105 whitespace-nowrap">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        ابحث
                    </button>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Links with Better Visibility -->
        <div class="flex flex-wrap justify-center gap-4 slide-up" style="animation-delay: 0.5s;">
            <a href="{{ route('services.index') }}" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                تصفح الخدمات
            </a>
            <a href="{{ route('providers.index') }}" class="px-8 py-4 bg-white/95 backdrop-blur-sm border-2 border-white text-brand-dark font-bold text-lg rounded-lg hover:bg-accent-DEFAULT hover:text-white hover:border-accent-DEFAULT shadow-xl hover:shadow-2xl transition-all duration-300">
                ابحث عن مقدمي الخدمات
            </a>
            @guest
            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-accent-copper to-accent-amber text-white font-bold text-lg rounded-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                كن مقدم خدمة
            </a>
            @endguest
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</div>

<!-- Features Section - HIGH CONTRAST WITH BACKGROUND -->
<section class="py-20 bg-cover bg-center bg-fixed relative overflow-hidden" style="background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.50), rgba(245, 241, 232, 0.55)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="geometric-overlay opacity-5"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-black mb-4 fade-in">
                لماذا تختار قيروان هب؟
            </h2>
            <div class="w-32 h-1 bg-gradient-to-r from-accent-DEFAULT to-accent-amber mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gradient-to-br from-kairouan-beige/70 via-kairouan-sandstone/65 to-accent-copper/60 backdrop-blur-sm p-8 rounded-2xl shadow-2xl hover:shadow-gold border-2 border-accent-DEFAULT/30 hover:border-accent-DEFAULT text-center transition-all duration-300 hover:-translate-y-2 stagger-item">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-6 shadow-gold">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-black mb-3">
                    موثوق
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    مقدمو خدمات معتمدون ومراجعات حقيقية من عملاء سابقين
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gradient-to-br from-kairouan-beige/70 via-kairouan-sandstone/65 to-accent-copper/60 backdrop-blur-sm p-8 rounded-2xl shadow-2xl hover:shadow-gold border-2 border-accent-DEFAULT/30 hover:border-accent-DEFAULT text-center transition-all duration-300 hover:-translate-y-2 stagger-item">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-6 shadow-gold">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-black mb-3">
                    سريع
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    احصل على عروض الأسعار من مقدمي الخدمات في دقائق معدودة
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gradient-to-br from-kairouan-beige/70 via-kairouan-sandstone/65 to-accent-copper/60 backdrop-blur-sm p-8 rounded-2xl shadow-2xl hover:shadow-gold border-2 border-accent-DEFAULT/30 hover:border-accent-DEFAULT text-center transition-all duration-300 hover:-translate-y-2 stagger-item">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-6 shadow-gold">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-black mb-3">
                    أسعار عادلة
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    قارن الأسعار من عدة مقدمي خدمات واختر الأفضل لك
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gradient-to-br from-kairouan-beige/70 via-kairouan-sandstone/65 to-accent-copper/60 backdrop-blur-sm p-8 rounded-2xl shadow-2xl hover:shadow-gold border-2 border-accent-DEFAULT/30 hover:border-accent-DEFAULT text-center transition-all duration-300 hover:-translate-y-2 stagger-item">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-6 shadow-gold">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-black mb-3">
                    محلي
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    مقدمو خدمات محليون في القيروان يعرفون احتياجاتك
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section - GREEN TO BEIGE GRADIENT WITH BACKGROUND -->
<section class="py-20 bg-cover bg-center bg-fixed relative" style="background-image: linear-gradient(to bottom, rgba(160, 137, 112, 0.60), rgba(245, 241, 232, 0.55)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="mosaic-tile absolute inset-0 opacity-5"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-black mb-4 fade-in">
                كيف يعمل؟
            </h2>
            <div class="w-32 h-1 bg-gradient-to-r from-accent-DEFAULT to-accent-amber mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
            <!-- Step 1 -->
            <div class="text-center stagger-item">
                <div class="relative inline-block mb-6">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white text-4xl font-bold shadow-gold">
                        1
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-accent-amber animate-pulse"></div>
                </div>
                <h3 class="text-2xl font-bold text-black mb-4">
                    اطلب خدمة
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    أخبرنا بالخدمة التي تحتاجها وتفاصيل مشروعك
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center stagger-item">
                <div class="relative inline-block mb-6">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white text-4xl font-bold shadow-gold">
                        2
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-accent-amber animate-pulse" style="animation-delay: 0.5s;"></div>
                </div>
                <h3 class="text-2xl font-bold text-black mb-4">
                    استلم العروض
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    احصل على عروض أسعار من مقدمي خدمات محترفين
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center stagger-item">
                <div class="relative inline-block mb-6">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white text-4xl font-bold shadow-gold">
                        3
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-accent-amber animate-pulse" style="animation-delay: 1s;"></div>
                </div>
                <h3 class="text-2xl font-bold text-black mb-4">
                    اختر الأفضل
                </h3>
                <p class="text-black text-lg leading-relaxed">
                    قارن العروض واختر مقدم الخدمة الأنسب لك
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section - LIGHTER VERSION -->
<section class="py-20 bg-cover bg-center bg-fixed relative overflow-hidden" style="background-image: linear-gradient(to bottom, rgba(212, 175, 55, 0.75), rgba(226, 142, 12, 0.70)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="absolute inset-0 geometric-overlay opacity-10"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 drop-shadow-lg fade-in">
            ابدأ الآن
        </h2>
        <p class="text-white/90 text-xl mb-10 max-w-2xl mx-auto fade-in font-medium">
            انضم إلى مجتمع القيروان الرقمي واحصل على أفضل الخدمات
        </p>
        <div class="flex flex-wrap justify-center gap-6 fade-in">
            <a href="{{ route('requests.create') }}" class="px-10 py-5 bg-white text-brand-dark rounded-xl font-bold text-lg shadow-2xl hover:shadow-gold hover:scale-105 transition-all duration-300 border-2 border-white">
                اطلب خدمة
            </a>
            @guest
            <a href="{{ route('register') }}" class="px-10 py-5 bg-transparent border-2 border-white text-white rounded-xl font-bold text-lg hover:bg-white hover:text-brand-dark transition-all duration-300 shadow-lg">
                انضم كمقدم خدمة
            </a>
            @endguest
        </div>
    </div>
</section>
@endsection
