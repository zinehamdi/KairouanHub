@extends('layouts.app')

@section('content')
    {{-- Service Hero Section with Premium Design --}}
    <div class="relative min-h-[50vh] flex items-center overflow-hidden">
        {{-- Background with gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-brand-dark via-deep-blue to-mediterranean-blue"></div>
        {{-- Pattern Overlay --}}
        <div class="absolute inset-0 opacity-10"
            style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.03) 20px, rgba(255,255,255,0.03) 40px);">
        </div>
        {{-- Decorative elements --}}
        <div class="absolute top-20 right-10 w-32 h-32 rounded-full bg-accent-DEFAULT/20 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-10 w-40 h-40 rounded-full bg-accent-amber/20 blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Breadcrumb --}}
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 rtl:space-x-reverse text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-white/60 hover:text-accent-amber transition-colors">
                            الرئيسية
                        </a>
                    </li>
                    <li class="text-white/40">/</li>
                    <li>
                        <a href="{{ route('services.index') }}"
                            class="text-white/60 hover:text-accent-amber transition-colors">
                            الخدمات
                        </a>
                    </li>
                    <li class="text-white/40">/</li>
                    <li class="text-white font-semibold">{{ $service->localized_name }}</li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-8 items-center">
                {{-- Service Icon --}}
                <div class="flex-shrink-0">
                    <x-service-icon :category="$service->category" :service="$service" size="xl"
                        class="w-28 h-28 md:w-36 md:h-36 rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300"
                        style="box-shadow: 0 0 40px rgba(212, 175, 55, 0.4);" />
                </div>

                {{-- Service Info --}}
                <div class="flex-1 text-center lg:text-right">
                    @if($service->category)
                        <div
                            class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm text-white font-bold text-sm rounded-full border border-white/20 mb-4">
                            {{ $service->category->localized_name }}
                        </div>
                    @endif

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                        {{ $service->localized_name }}
                    </h1>

                    @if($service->localized_summary || $service->description)
                        <p class="text-xl text-white/90 leading-relaxed mb-6 max-w-2xl">
                            {{ $service->localized_summary ?? $service->description }}
                        </p>
                    @endif

                    {{-- Quick Stats with glass effect --}}
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 mb-8">
                        <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full">
                            <svg class="w-5 h-5 text-accent-amber" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            <span class="text-white font-medium">{{ __('services.available_providers_text') }}</span>
                        </div>

                        <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full">
                            <svg class="w-5 h-5 text-accent-amber" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-white font-medium">{{ __('services.flexible_schedule') }}</span>
                        </div>

                        <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full">
                            <svg class="w-5 h-5 text-accent-amber" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-white font-medium">{{ __('services.quality_guaranteed') }}</span>
                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="{{ route('requests.create', ['service' => $service->slug]) }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-xl shadow-2xl hover:shadow-gold hover:scale-105 transition-all duration-300">
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('services.request_this_service') }}
                        </a>

                        <a href="{{ route('providers.index', ['service' => $service->slug]) }}"
                            class="inline-flex items-center px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white font-bold text-lg rounded-xl hover:bg-white hover:text-brand-dark shadow-lg transition-all duration-300">
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            {{ __('services.find_providers') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Service Details Section --}}
    <div class="py-16 bg-gradient-to-b from-kairouan-warm-cream to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">

                {{-- What's Included --}}
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 mb-12">
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-brand-dark">{{ __('services.whats_included') }}</h2>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div
                            class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100">
                            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-brand-dark mb-1">{{ __('services.feature_1_title') }}</h4>
                                <p class="text-gray-600 text-sm">{{ __('services.feature_1_desc') }}</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100">
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-brand-dark mb-1">{{ __('services.feature_2_title') }}</h4>
                                <p class="text-gray-600 text-sm">{{ __('services.feature_2_desc') }}</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100">
                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-brand-dark mb-1">{{ __('services.feature_3_title') }}</h4>
                                <p class="text-gray-600 text-sm">{{ __('services.feature_3_desc') }}</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-100">
                            <div
                                class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-brand-dark mb-1">{{ __('services.feature_4_title') }}</h4>
                                <p class="text-gray-600 text-sm">{{ __('services.feature_4_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- How It Works --}}
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-brand-dark mb-10 text-center">{{ __('services.how_it_works') }}</h2>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="text-center group">
                            <div class="relative mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white text-3xl font-bold shadow-xl group-hover:scale-110 transition-transform duration-300">
                                    1
                                </div>
                                <div
                                    class="hidden md:block absolute top-1/2 right-0 w-full h-0.5 bg-gradient-to-r from-accent-DEFAULT/50 to-transparent -z-10 translate-x-1/2">
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-brand-dark mb-2">{{ __('services.step_1_title') }}</h3>
                            <p class="text-gray-600">{{ __('services.step_1_desc') }}</p>
                        </div>

                        <div class="text-center group">
                            <div class="relative mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white text-3xl font-bold shadow-xl group-hover:scale-110 transition-transform duration-300">
                                    2
                                </div>
                                <div
                                    class="hidden md:block absolute top-1/2 right-0 w-full h-0.5 bg-gradient-to-r from-accent-DEFAULT/50 to-transparent -z-10 translate-x-1/2">
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-brand-dark mb-2">{{ __('services.step_2_title') }}</h3>
                            <p class="text-gray-600">{{ __('services.step_2_desc') }}</p>
                        </div>

                        <div class="text-center group">
                            <div class="relative mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber text-white text-3xl font-bold shadow-xl group-hover:scale-110 transition-transform duration-300">
                                    3
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-brand-dark mb-2">{{ __('services.step_3_title') }}</h3>
                            <p class="text-gray-600">{{ __('services.step_3_desc') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Final CTA --}}
                <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-accent-DEFAULT via-accent-amber to-kairouan-brass">
                    </div>
                    <div class="absolute inset-0 opacity-10"
                        style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M30 0l5 15h16l-13 9 5 16-13-9-13 9 5-16-13-9h16z\' fill=\'%23fff\' fill-opacity=\'1\'/%3E%3C/svg%3E');">
                    </div>
                    <div class="relative z-10 p-12 text-center">
                        <h2 class="text-4xl font-bold text-white mb-4">{{ __('services.ready_to_start') }}</h2>
                        <p class="text-white/90 text-xl mb-8 max-w-2xl mx-auto">{{ __('services.cta_desc_show') }}</p>
                        <a href="{{ route('requests.create', ['service' => $service->slug]) }}"
                            class="inline-block px-12 py-5 bg-white text-accent-DEFAULT font-bold text-xl rounded-xl shadow-2xl hover:shadow-gold hover:scale-105 transition-all duration-300">
                            {{ __('services.request_now_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($service->category && $service->category->services->count() > 1)
        {{-- Related Services --}}
        <div class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-brand-dark mb-10 text-center">{{ __('services.related_services') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    @foreach($service->category->services->where('id', '!=', $service->id)->take(3) as $relatedService)
                        <a href="{{ route('services.show', $relatedService->slug) }}"
                            class="group bg-gradient-to-br from-kairouan-warm-cream to-white p-6 rounded-2xl shadow-lg hover:shadow-2xl border-2 border-transparent hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2">
                            <div
                                class="flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3
                                class="text-xl font-bold text-brand-dark mb-2 group-hover:text-accent-DEFAULT transition-colors duration-300">
                                {{ $relatedService->localized_name }}
                            </h3>
                            @if($relatedService->localized_summary)
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ Str::limit($relatedService->localized_summary, 80) }}
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection