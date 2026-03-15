@extends('layouts.app')

@section('title_prefix', __('seo.home_title', ['app_name' => config('app.name')]))
@section('title_suffix', __('seo.home_subtitle'))
@section('description', __('seo.home_description', ['app_name' => config('app.name')]))

@section('content')
    {{-- Hero Section with Great Mosque Background --}}
    <div class="relative min-h-[70vh] md:min-h-[60vh] flex items-center justify-center overflow-hidden">
        {{-- Background Image - Great Mosque of Kairouan --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/kairouan-background.jpg') }}" alt="Great Mosque of Kairouan"
                class="w-full h-full object-cover" style="object-position: 70% 30%;">
            {{-- Gradient Overlay for readability - STRONG --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-brand-dark/70 to-deep-blue/90"></div>
            {{-- Additional dark layer for mobile --}}
            <div class="absolute inset-0 bg-black/30 md:bg-black/20"></div>
            {{-- Animated pattern overlay --}}
            <div class="absolute inset-0 opacity-10"
                style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.03) 20px, rgba(255,255,255,0.03) 40px);">
            </div>
        </div>

        {{-- Floating decorative elements --}}
        <div class="absolute top-20 left-10 w-20 h-20 rounded-full bg-accent-DEFAULT/20 blur-2xl animate-pulse"></div>
        <div class="absolute bottom-32 right-10 w-32 h-32 rounded-full bg-accent-amber/20 blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>

        {{-- Hero Content --}}
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center py-12">
            {{-- HUGE KairouanHub Title Badge --}}
            <div class="mb-8 animate-fade-in">
                {{-- Main Title Badge --}}
                <div class="relative inline-block">
                    {{-- Glow Effect Behind --}}
                    <div class="absolute inset-0 blur-3xl opacity-60"
                        style="background: radial-gradient(ellipse, #D4AF37 0%, #E8B545 30%, transparent 70%);"></div>

                    {{-- The Title --}}
                    <h1 class="relative text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-black tracking-tight"
                        style="font-family: 'Tajawal', sans-serif;
                                               background: linear-gradient(135deg, #D4AF37 0%, #F5E6A3 25%, #E8B545 50%, #D4AF37 75%, #B87333 100%);
                                               background-size: 200% 200%;
                                               -webkit-background-clip: text;
                                               -webkit-text-fill-color: transparent;
                                               background-clip: text;
                                               animation: shimmer 3s ease-in-out infinite;
                                               text-shadow: none;
                                               filter: drop-shadow(0 4px 20px rgba(212,175,55,0.5)) drop-shadow(0 8px 40px rgba(184,115,51,0.3));">
                        KairouanHub
                    </h1>

                    {{-- Decorative sparkles --}}
                    <div class="absolute -top-4 -right-4 md:-top-6 md:-right-6">
                        <svg class="w-8 h-8 md:w-12 md:h-12 text-accent-amber animate-pulse" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M12 0L14.59 8.41L23 11L14.59 13.59L12 22L9.41 13.59L1 11L9.41 8.41L12 0Z" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-2 -left-2 md:-bottom-4 md:-left-4">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-accent-DEFAULT animate-pulse" style="animation-delay: 0.5s;"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0L14.59 8.41L23 11L14.59 13.59L12 22L9.41 13.59L1 11L9.41 8.41L12 0Z" />
                        </svg>
                    </div>
                </div>

                {{-- Subtitle Badge --}}
                <div class="mt-4 md:mt-6">
                    <span
                        class="inline-block px-6 py-2 md:px-8 md:py-3 rounded-full text-sm md:text-base font-bold text-white uppercase tracking-widest"
                        style="background: linear-gradient(135deg, rgba(212,175,55,0.3) 0%, rgba(232,181,69,0.2) 100%);
                                               border: 2px solid rgba(212,175,55,0.5);
                                               backdrop-filter: blur(10px);
                                               text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                        🏛️ {{ __('home.badge_kairouan') ?? 'منصة خدمات القيروان الأولى' }} 🌟
                    </span>
                </div>
            </div>

            {{-- Logo (smaller now) --}}
            <div class="mb-4 animate-fade-in" style="animation-delay: 0.1s;">
                <img src="{{ asset('images/kairouanhubLogo.PNG') }}" alt="KairouanHub"
                    class="h-14 md:h-20 mx-auto drop-shadow-2xl opacity-90"
                    style="filter: drop-shadow(0 0 20px rgba(224, 122, 95, 0.3));">
            </div>

            {{-- Tagline with elegant typography --}}
            <h1 class="text-white text-2xl md:text-3xl font-bold mb-4 animate-slide-up"
                style="font-family: 'Amiri', serif; animation-delay: 0.1s; text-shadow: 2px 2px 8px rgba(0,0,0,0.8), 0 0 40px rgba(0,0,0,0.5);">
                {{ __('home.hero_subtitle') }}
            </h1>

            <p class="text-white text-lg md:text-xl mb-8 max-w-2xl mx-auto animate-slide-up font-medium"
                style="animation-delay: 0.2s; text-shadow: 1px 1px 6px rgba(0,0,0,0.7);">
                {{ __('home.hero_description') }}
            </p>

            {{-- Search Bar with glass effect --}}
            <div class="max-w-2xl mx-auto mb-8 animate-slide-up" style="animation-delay: 0.3s;">
                <form action="{{ route('services.index') }}" method="GET" class="relative">
                    <div
                        class="flex items-center bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border-2 border-white/20 hover:border-accent-DEFAULT/50 transition-all duration-300">
                        <div class="flex-1 relative">
                            <svg class="absolute right-4 rtl:right-auto rtl:left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search"
                                class="w-full px-6 py-5 bg-transparent border-0 focus:ring-0 text-gray-800 placeholder:text-gray-500 text-lg font-medium"
                                placeholder="{{ __('home.search_placeholder') }}" />
                        </div>
                        <button type="submit"
                            class="flex-shrink-0 px-8 py-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-DEFAULT text-white font-bold text-lg transition-all duration-300 hover:shadow-lg">
                            {{ __('home.search_button') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Quick Stats --}}
            <div class="flex flex-wrap justify-center gap-6 md:gap-10 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="text-center px-4 py-2 bg-black/30 backdrop-blur-sm rounded-xl">
                    <div class="text-3xl md:text-4xl font-bold text-white"
                        style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                        {{ \App\Models\Service::count() }}+
                    </div>
                    <div class="text-white text-sm font-medium">{{ __('home.categories_title') }}</div>
                </div>
                <div class="w-px h-12 bg-white/30 hidden md:block"></div>
                <div class="text-center px-4 py-2 bg-black/30 backdrop-blur-sm rounded-xl">
                    <div class="text-3xl md:text-4xl font-bold text-white"
                        style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                        {{ \App\Models\ProviderProfile::where('status', 'approved')->count() }}+
                    </div>
                    <div class="text-white text-sm font-medium">{{ __('home.featured_providers') }}</div>
                </div>
                <div class="w-px h-12 bg-white/30 hidden md:block"></div>
                <div class="text-center px-4 py-2 bg-black/30 backdrop-blur-sm rounded-xl">
                    <div class="text-3xl md:text-4xl font-bold text-accent-amber"
                        style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">100%</div>
                    <div class="text-white text-sm font-medium">{{ __('home.feature_local') }}</div>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </div>

    {{-- Quick Actions Section --}}
    <section class="py-10 bg-gradient-to-b from-deep-blue to-brand-dark relative overflow-hidden">
        {{-- Decorative background --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-1/4 w-64 h-64 rounded-full bg-accent-DEFAULT blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 rounded-full bg-accent-amber blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-8 text-center"
                style="text-shadow: 2px 2px 8px rgba(0,0,0,0.9);">
                {{ __('home.quick_actions_title') }}
            </h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <a href="{{ route('requests.create') }}"
                    class="group relative bg-gradient-to-br from-white/15 to-white/10 backdrop-blur-md rounded-2xl p-6 border-2 border-white/20 hover:border-accent-DEFAULT/50 hover:bg-white/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                        {{ __('home.request_service') }}
                    </h3>
                    <p class="text-white/80 text-sm" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">
                        {{ __('home.request_service_desc') }}
                    </p>
                    <div
                        class="absolute top-4 left-4 rtl:left-auto rtl:right-4 w-2 h-2 rounded-full bg-accent-DEFAULT opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </a>

                {{-- Explore Services --}}
                <a href="{{ route('services.index') }}"
                    class="group relative bg-gradient-to-br from-white/15 to-white/10 backdrop-blur-md rounded-2xl p-6 border-2 border-white/20 hover:border-emerald-400/50 hover:bg-white/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                        {{ __('home.explore_services') }}
                    </h3>
                    <p class="text-white/80 text-sm" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">
                        {{ __('home.explore_services_desc') }}
                    </p>
                    <div
                        class="absolute top-4 left-4 rtl:left-auto rtl:right-4 w-2 h-2 rounded-full bg-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </a>

                {{-- Suggest Provider --}}
                @auth
                    <a href="{{ route('providers.suggest') }}"
                        class="group relative bg-gradient-to-br from-white/15 to-white/10 backdrop-blur-md rounded-2xl p-6 border-2 border-white/20 hover:border-violet-400/50 hover:bg-white/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                            {{ __('home.suggest_provider') }}
                        </h3>
                        <p class="text-white/80 text-sm" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">
                            {{ __('home.suggest_provider_desc') }}
                        </p>
                        <div
                            class="absolute top-4 left-4 rtl:left-auto rtl:right-4 w-2 h-2 rounded-full bg-violet-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="group relative bg-gradient-to-br from-white/15 to-white/10 backdrop-blur-md rounded-2xl p-6 border-2 border-white/20 hover:border-violet-400/50 hover:bg-white/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                            {{ __('home.become_provider') }}
                        </h3>
                        <p class="text-white/80 text-sm" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">
                            {{ __('home.suggest_provider_desc') }}
                        </p>
                        <div
                            class="absolute top-4 left-4 rtl:left-auto rtl:right-4 w-2 h-2 rounded-full bg-violet-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                @endauth

                {{-- Browse All --}}
                <a href="{{ route('services.index') }}"
                    class="group relative bg-gradient-to-br from-white/15 to-white/10 backdrop-blur-md rounded-2xl p-6 border-2 border-white/20 hover:border-blue-400/50 hover:bg-white/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl shadow-lg">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center mb-4 shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                        {{ __('home.browse_all') }}
                    </h3>
                    <p class="text-white/80 text-sm" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.6);">
                        {{ __('home.browse_all_desc') }}
                    </p>
                    <div
                        class="absolute top-4 left-4 rtl:left-auto rtl:right-4 w-2 h-2 rounded-full bg-blue-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Categories Scroll Section --}}
    @if($categories->count() > 0)
        <section class="py-12 bg-gradient-to-b from-gray-50 to-gray-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-brand-dark">
                            {{ __('home.categories_title') }}
                        </h2>
                        <p class="text-gray-600 mt-1">{{ __('home.hero_description') }}</p>
                    </div>
                    <a href="{{ route('services.index') }}"
                        class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-brand-dark hover:bg-accent-DEFAULT text-white font-medium rounded-xl transition-all duration-300">
                        {{ __('home.view_all') }}
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <x-category-scroll :categories="$categories" />

                {{-- Mobile view all button --}}
                <div class="mt-6 text-center md:hidden">
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-brand-dark hover:bg-accent-DEFAULT text-white font-medium rounded-xl transition-all duration-300">
                        {{ __('home.view_all') }}
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Featured Providers Section --}}
    @if($featuredProviders->count() > 0)
        <section class="py-12 bg-gradient-to-b from-white to-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-brand-dark">
                            {{ __('home.featured_providers') }}
                        </h2>
                        <p class="text-gray-600 mt-1">{{ __('home.featured_providers_desc') }}</p>
                    </div>
                    <a href="{{ route('services.index') }}"
                        class="hidden md:flex items-center gap-2 px-5 py-2.5 bg-accent-DEFAULT hover:bg-accent-amber text-white font-medium rounded-xl transition-all duration-300">
                        {{ __('home.view_all') }}
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($featuredProviders as $provider)
                        <x-provider-card-compact :provider="$provider" />
                    @endforeach
                </div>

                {{-- Mobile view all button --}}
                <div class="mt-8 text-center md:hidden">
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-accent-DEFAULT hover:bg-accent-amber text-white font-medium rounded-xl transition-all duration-300">
                        {{ __('home.view_all') }}
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Community Feed Section --}}
    @if($recentRequests->count() > 0)
        <section class="py-12 bg-gradient-to-br from-gray-100 to-slate-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-brand-dark">
                            {{ __('home.community_feed') }}
                        </h2>
                        <p class="text-gray-600 mt-1">{{ __('home.community_feed_desc') }}</p>
                    </div>
                    <a href="{{ route('requests.index') }}"
                        class="hidden md:flex items-center gap-2 text-accent-DEFAULT hover:text-accent-amber font-medium transition-colors duration-300">
                        {{ __('home.view_all') }}
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach($recentRequests as $request)
                        <a href="{{ route('requests.show', $request->id) }}"
                            class="block bg-white hover:bg-accent-DEFAULT/5 rounded-2xl p-5 shadow-soft hover:shadow-xl border border-gray-100 hover:border-accent-DEFAULT/30 transition-all duration-300 group">
                            <div class="flex items-start gap-4">
                                {{-- Icon --}}
                                <div
                                    class="flex-shrink-0 w-14 h-14 rounded-xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-lg">
                                    @if($request->service)
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    @elseif($request->category)
                                        <span class="text-2xl">{{ $request->category->icon ?? '📋' }}</span>
                                    @else
                                        <span
                                            class="text-white font-bold text-xl">{{ mb_substr($request->user->name ?? '?', 0, 1) }}</span>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="font-bold text-brand-dark group-hover:text-accent-DEFAULT transition-colors duration-300 line-clamp-2 text-lg">
                                        {{ $request->title ?? \Illuminate\Support\Str::limit($request->details, 80) }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-3 mt-2">
                                        @if($request->service)
                                            <span
                                                class="inline-flex items-center gap-1 bg-accent-DEFAULT/10 text-accent-DEFAULT px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $request->service->localized_name ?? $request->service->name }}
                                            </span>
                                        @elseif($request->category)
                                            <span
                                                class="inline-flex items-center gap-1 bg-accent-DEFAULT/10 text-accent-DEFAULT px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $request->category->localized_name ?? $request->category->name }}
                                            </span>
                                        @endif
                                        @if($request->city)
                                            <span class="inline-flex items-center gap-1 text-gray-500 text-sm">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $request->city }}
                                            </span>
                                        @endif
                                        <span class="text-gray-400 text-sm">
                                            {{ $request->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Arrow --}}
                                <div
                                    class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-100 group-hover:bg-accent-DEFAULT flex items-center justify-center transition-all duration-300">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white rtl:rotate-180 transition-colors duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- How It Works Section - Enhanced --}}
    <section class="py-20 bg-white relative overflow-hidden">
        {{-- Background Decorations --}}
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-accent-DEFAULT/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-accent-amber/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-accent-DEFAULT/10 text-accent-DEFAULT text-sm font-bold uppercase tracking-widest mb-4">
                    {{ __('home.process') ?? 'ببساطة' }}
                </span>
                <h2 class="text-4xl md:text-5xl font-black text-brand-dark mb-6">
                    {{ __('home.how_it_works') }}
                </h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber mx-auto rounded-full mb-6"></div>
                <p class="text-gray-600 text-lg">
                    {{ __('home.how_it_works_desc') ?? 'KairouanHub يسهلك حياتك ويوصلك بأحسن الصنايعية في القيروان في 3 خطوات.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                {{-- Step 1 --}}
                <div class="relative group">
                    <div class="absolute -top-6 -left-6 text-8xl font-black text-gray-100 group-hover:text-accent-DEFAULT/10 transition-colors duration-500 select-none">1</div>
                    <div class="relative bg-white p-8 rounded-3xl shadow-soft group-hover:shadow-2xl transition-all duration-500 border border-gray-100 group-hover:border-accent-DEFAULT/20 group-hover:-translate-y-2">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center mb-6 shadow-lg group-hover:rotate-6 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-brand-dark mb-4">{{ __('home.step1_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ __('home.step1_desc') }}</p>
                        <div class="mt-6 flex items-center text-accent-DEFAULT font-bold text-sm uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ __('home.start_now') ?? 'ابدأ توة' }}
                            <svg class="w-4 h-4 ml-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative group">
                    <div class="absolute -top-6 -left-6 text-8xl font-black text-gray-100 group-hover:text-accent-amber/10 transition-colors duration-500 select-none">2</div>
                    <div class="relative bg-white p-8 rounded-3xl shadow-soft group-hover:shadow-2xl transition-all duration-500 border border-gray-100 group-hover:border-accent-amber/20 group-hover:-translate-y-2">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center mb-6 shadow-lg group-hover:-rotate-6 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-brand-dark mb-4">{{ __('home.step2_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ __('home.step2_desc') }}</p>
                        <div class="mt-6 flex items-center text-accent-amber font-bold text-sm uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ __('home.compare_offers') ?? 'قارن العروض' }}
                            <svg class="w-4 h-4 ml-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative group">
                    <div class="absolute -top-6 -left-6 text-8xl font-black text-gray-100 group-hover:text-emerald-500/10 transition-colors duration-500 select-none">3</div>
                    <div class="relative bg-white p-8 rounded-3xl shadow-soft group-hover:shadow-2xl transition-all duration-500 border border-gray-100 group-hover:border-emerald-500/20 group-hover:-translate-y-2">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-brand-dark mb-4">{{ __('home.step3_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ __('home.step3_desc') }}</p>
                        <div class="mt-6 flex items-center text-emerald-600 font-bold text-sm uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ __('home.service_done') ?? 'تمت الخدمة' }}
                            <svg class="w-4 h-4 ml-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Points & Rewards Promotional Section --}}
    <section class="py-16 bg-gradient-to-br from-brand-dark to-deep-blue relative overflow-hidden">
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M54.627 0l.83.83L25.933 30.354l-11.233-11.233L1.077 32.747l-.83-.83L14.7 17.443 25.933 28.676 54.627 0z\" fill=\"%23D4AF37\" fill-opacity=\"1\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                {{-- Text Content --}}
                <div class="flex-1 text-right lg:text-right">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-amber/20 border border-accent-amber/30 text-accent-amber font-bold text-sm mb-6 animate-pulse">
                        <span class="flex h-2 w-2 rounded-full bg-accent-amber"></span>
                        {{ __('home.points_new') ?? 'جديد: نظام النقاط' }}
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black text-white mb-6 leading-tight">
                        {{ __('home.points_title') ?? 'أوصي بصنايعي ثقة وأربح نقاط!' }}
                    </h2>
                    <p class="text-white/80 text-lg mb-8 max-w-2xl ml-auto">
                        {{ __('home.points_desc') ?? 'في KairouanHub، كل مساهمة منك عندها قيمة. إذا تعرف صنايعي ولا مولى صنعة باهي في القيروان، أوصي بيه في المنصة، وبمجرد ما نقبلوه، تربح 50 نقطة تزيد في رصيدك وثقتك.' }}
                    </p>
                    <div class="flex flex-wrap gap-4 justify-end">
                        <a href="{{ route('providers.suggest') }}" class="px-8 py-4 bg-accent-amber hover:bg-white hover:text-brand-dark text-brand-dark font-black rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-orange-500/20">
                            {{ __('home.suggest_now_earn') ?? 'أوصي الآن واربح' }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all">
                            {{ __('home.my_points') ?? 'رصيد نقاطي' }}
                        </a>
                    </div>
                </div>

                {{-- Visual Element (Points Card Mockup) --}}
                <div class="flex-1 relative w-full max-w-md">
                    <div class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl p-8 rounded-[2rem] border border-white/20 shadow-2xl">
                        <div class="flex justify-between items-start mb-10">
                            <div>
                                <div class="text-white/60 text-sm font-medium mb-1">Total Balance</div>
                                <div class="text-4xl font-black text-white tracking-tight">2,450 <span class="text-accent-amber text-xl">Points</span></div>
                            </div>
                            <div class="w-14 h-14 rounded-2xl bg-accent-amber/20 flex items-center justify-center">
                                <svg class="w-8 h-8 text-accent-amber" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/5">
                                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-white text-sm font-bold">Provider Suggestion Approved</div>
                                    <div class="text-white/40 text-xs">Today at 14:30</div>
                                </div>
                                <div class="text-emerald-400 font-bold">+50</div>
                            </div>
                            <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/5 translate-x-4 opacity-70">
                                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-white text-sm font-bold">Profile Verification</div>
                                    <div class="text-white/40 text-xs">Yesterday</div>
                                </div>
                                <div class="text-blue-400 font-bold">+100</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Decorative Sparkles --}}
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-accent-amber/20 blur-3xl rounded-full"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-accent-DEFAULT/20 blur-3xl rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA Section --}}
    <section class="relative py-20 overflow-hidden">
        {{-- Background with mosque image --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/kairouan-background.jpg') }}" alt="" class="w-full h-full object-cover"
                style="object-position: 50% 60%;">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-dark/95 via-mediterranean-blue/90 to-deep-blue/95">
            </div>
        </div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6 drop-shadow-lg">
                {{ __('home.cta_title') }}
            </h2>
            <p class="text-white/90 text-xl mb-10 max-w-2xl mx-auto">
                {{ __('home.cta_description') }}
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('requests.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-10 py-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-DEFAULT text-white font-bold text-lg rounded-2xl shadow-2xl hover:shadow-gold hover:scale-105 transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('home.request_service') }}
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center gap-2 px-10 py-5 bg-white/10 backdrop-blur-sm border-2 border-white/30 hover:bg-white hover:text-brand-dark text-white font-bold text-lg rounded-2xl shadow-xl transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        {{ __('home.join_as_provider') }}
                    </a>
                @endguest
            </div>
        </div>
    </section>

    {{-- Chatbot Widget --}}
    <x-chatbot-widget />

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out forwards;
        }
    </style>
@endsection