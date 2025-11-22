@extends('layouts.app')

@section('content')
    <!-- Hero Section - Mediterranean Style -->
    <div class="hero-mediterranean relative bg-cover bg-center bg-no-repeat min-h-screen flex items-center justify-center"
        style="background-image: linear-gradient(to bottom, rgba(38, 70, 83, 0.50), rgba(61, 90, 128, 0.45)), url('{{ asset('images/kairouan-background.jpg') }}');">

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            <!-- Logo with Hub Network Effect -->
            <div class="mb-8 fade-in relative">
                <!-- Network Connection Lines -->
                <div class="absolute inset-0 -m-24">
                    <svg class="w-full h-full opacity-20" viewBox="0 0 400 400">
                        <!-- Animated lines radiating from center -->
                        <g class="animate-pulse">
                            <line x1="200" y1="200" x2="320" y2="120" stroke="#E07A5F" stroke-width="1" opacity="0.5">
                                <animate attributeName="opacity" values="0.3;0.7;0.3" dur="3s" repeatCount="indefinite" />
                            </line>
                            <line x1="200" y1="200" x2="350" y2="200" stroke="#3D5A80" stroke-width="1" opacity="0.5">
                                <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.5s" repeatCount="indefinite" />
                            </line>
                            <line x1="200" y1="200" x2="320" y2="280" stroke="#E07A5F" stroke-width="1" opacity="0.5">
                                <animate attributeName="opacity" values="0.4;0.8;0.4" dur="3.2s" repeatCount="indefinite" />
                            </line>
                            <line x1="200" y1="200" x2="80" y2="120" stroke="#3D5A80" stroke-width="1" opacity="0.5">
                                <animate attributeName="opacity" values="0.3;0.7;0.3" dur="2.8s" repeatCount="indefinite" />
                            </line>
                            <line x1="200" y1="200" x2="50" y2="200" stroke="#E07A5F" stroke-width="1" opacity="0.5">
                                <animate attributeName="opacity" values="0.5;0.9;0.5" dur="3.5s" repeatCount="indefinite" />
                            </line>
                            <line x1="200" y1="200" x2="80" y2="280" stroke="#3D5A80" stroke-width="1" opacity="0.5">
                                <animate attributeName="opacity" values="0.4;0.8;0.4" dur="2.7s" repeatCount="indefinite" />
                            </line>
                        </g>
                        <!-- Connection nodes -->
                        <circle cx="320" cy="120" r="4" fill="#E07A5F" opacity="0.6">
                            <animate attributeName="r" values="3;5;3" dur="2s" repeatCount="indefinite" />
                        </circle>
                        <circle cx="350" cy="200" r="4" fill="#3D5A80" opacity="0.6">
                            <animate attributeName="r" values="3;5;3" dur="2.2s" repeatCount="indefinite" />
                        </circle>
                        <circle cx="320" cy="280" r="4" fill="#E07A5F" opacity="0.6">
                            <animate attributeName="r" values="3;5;3" dur="2.4s" repeatCount="indefinite" />
                        </circle>
                        <circle cx="80" cy="120" r="4" fill="#3D5A80" opacity="0.6">
                            <animate attributeName="r" values="3;5;3" dur="2.6s" repeatCount="indefinite" />
                        </circle>
                        <circle cx="50" cy="200" r="4" fill="#E07A5F" opacity="0.6">
                            <animate attributeName="r" values="3;5;3" dur="2.8s" repeatCount="indefinite" />
                        </circle>
                        <circle cx="80" cy="280" r="4" fill="#3D5A80" opacity="0.6">
                            <animate attributeName="r" values="3;5;3" dur="3s" repeatCount="indefinite" />
                        </circle>
                        <!-- Center hub -->
                        <circle cx="200" cy="200" r="6" fill="#F4A261" opacity="0.8" />
                    </svg>
                </div>
                <!-- Logo -->
                <img src="{{ asset('images/kairouanhubLogo.PNG') }}" alt="KairouanHub Logo"
                    class="h-32 md:h-40 mx-auto drop-shadow-2xl relative z-10">
            </div>

            <!-- Main Heading -->
            <h1 class="text-5xl md:text-7xl font-heading font-bold mb-6 leading-tight tracking-tight slide-up">
                <span class="block text-white drop-shadow-lg">
                    KairouanHub
                </span>
                <span class="block text-3xl md:text-4xl text-white/90 mt-2" style="font-family: 'Amiri', serif;">
                    منصة الخدمات المحلية
                </span>
            </h1>

            <p class="text-xl md:text-2xl mb-4 text-white/95 drop-shadow-md slide-up" style="animation-delay: 0.2s;">
                القيروان، روح التراث ومستقبل التقنية
            </p>

            <p class="text-base md:text-lg mb-10 text-white/80 font-light drop-shadow-md slide-up"
                style="animation-delay: 0.3s;">
                Kairouan, the soul of heritage and the future of tech
            </p>

            <!-- Search Bar -->
            <div class="max-w-3xl mx-auto mb-12 slide-up" style="animation-delay: 0.4s;">
                <form action="{{ route('services.index') }}" method="GET" class="relative">
                    <div class="flex items-center gap-3 p-2 bg-white rounded-2xl shadow-2xl">
                        <div class="flex-1">
                            <input type="text" name="search"
                                class="w-full px-6 py-4 bg-transparent border-0 focus:ring-0 text-gray-800 placeholder:text-gray-500 text-lg font-medium"
                                placeholder="ابحث عن خدمة..." />
                        </div>
                        <button type="submit" class="btn-mediterranean whitespace-nowrap">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            ابحث
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-wrap justify-center gap-4 slide-up" style="animation-delay: 0.5s;">
                <a href="{{ route('services.index') }}" class="btn-terracotta">
                    <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    تصفح الخدمات
                </a>
                <a href="{{ route('providers.index') }}" class="btn-outline-mediterranean">
                    <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    ابحث عن مقدمي الخدمات
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn-mediterranean">
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        كن مقدم خدمة
                    </a>
                @endguest
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-24 bg-soft-cream">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-heading font-bold mb-4 fade-in"
                    style="font-family: 'Amiri', serif; color: var(--color-deep-blue);">
                    لماذا تختار قيروان هب؟
                </h2>
                <div class="w-24 h-1 bg-terracotta mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="card-mediterranean p-8 text-center stagger-item">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-terracotta-gradient mb-6 shadow-soft">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-3">
                        موثوق
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        مقدمو خدمات معتمدون ومراجعات حقيقية من عملاء سابقين
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card-mediterranean p-8 text-center stagger-item">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-terracotta-gradient mb-6 shadow-soft">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-3">
                        سريع
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        احصل على عروض الأسعار من مقدمي الخدمات في دقائق معدودة
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card-mediterranean p-8 text-center stagger-item">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-terracotta-gradient mb-6 shadow-soft">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-3">
                        أسعار عادلة
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        قارن الأسعار من عدة مقدمي خدمات واختر الأفضل لك
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="card-mediterranean p-8 text-center stagger-item">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-terracotta-gradient mb-6 shadow-soft">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-3">
                        محلي
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        مقدمو خدمات محليون في القيروان يعرفون احتياجاتك
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-heading font-bold text-deep-blue mb-4 fade-in">
                    كيف يعمل؟
                </h2>
                <div class="w-24 h-1 bg-terracotta mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto">
                <!-- Step 1 -->
                <div class="text-center stagger-item">
                    <div
                        class="w-24 h-24 rounded-full bg-terracotta-gradient flex items-center justify-center text-white text-4xl font-bold shadow-soft mx-auto mb-6">
                        1
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-4">
                        اطلب خدمة
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        أخبرنا بالخدمة التي تحتاجها وتفاصيل مشروعك
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center stagger-item">
                    <div
                        class="w-24 h-24 rounded-full bg-terracotta-gradient flex items-center justify-center text-white text-4xl font-bold shadow-soft mx-auto mb-6">
                        2
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-4">
                        استلم العروض
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        احصل على عروض أسعار من مقدمي خدمات محترفين
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center stagger-item">
                    <div
                        class="w-24 h-24 rounded-full bg-terracotta-gradient flex items-center justify-center text-white text-4xl font-bold shadow-soft mx-auto mb-6">
                        3
                    </div>
                    <h3 class="text-2xl font-bold text-deep-blue mb-4">
                        اختر الأفضل
                    </h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        قارن العروض واختر مقدم الخدمة الأنسب لك
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-blue-gradient">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 drop-shadow-lg fade-in">
                ابدأ الآن
            </h2>
            <p class="text-white/90 text-xl mb-10 max-w-2xl mx-auto fade-in font-medium">
                انضم إلى مجتمع القيروان الرقمي واحصل على أفضل الخدمات
            </p>
            <div class="flex flex-wrap justify-center gap-6 fade-in">
                <a href="{{ route('requests.create') }}"
                    class="px-10 py-5 bg-white text-mediterranean-blue rounded-xl font-bold text-lg shadow-2xl hover:shadow-soft-lg hover:scale-105 transition-all duration-300">
                    اطلب خدمة
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="px-10 py-5 bg-transparent border-2 border-white text-white rounded-xl font-bold text-lg hover:bg-white hover:text-mediterranean-blue transition-all duration-300 shadow-lg">
                        انضم كمقدم خدمة
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Floating window invitation -->
    <div id="joinWindow"
        style="position: fixed; top: 30px; left: 30px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); width: 350px; max-height: 90vh; overflow: hidden; z-index: 9999; font-family: 'Cairo', sans-serif;">
        <div style="background:#14532d; color:white; padding:10px 15px; font-weight:600;">
            🌿 نحن بصدد التحسين ونبحث عن موهوبين معنا
        </div>
        <iframe
            src="https://docs.google.com/forms/d/e/1FAIpQLSdg3cAyniKqcmqFgshHI3AhiIcQYrmEA519LyZwy6upZLTIMQ/viewform?usp=header"
            style="width:100%; height:400px; border:none;"></iframe>
        <button onclick="document.getElementById('joinWindow').style.display='none'"
            style="width:100%; background:#d97706; color:white; border:none; padding:10px; cursor:pointer;">إغلاق</button>
    </div>
@endsection