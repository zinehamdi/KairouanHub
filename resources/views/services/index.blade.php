@extends('layouts.app')

@section('content')
@section('title_prefix', __('seo.services_title'))
@section('description', __('seo.services_description'))

    {{-- Pass hierarchical data for browser --}}
    <div x-data="serviceBrowser({{ json_encode($browserData) }})" class="min-h-screen bg-gray-50/50">

    <!-- Services Hero Section -->
    <div class="relative bg-gradient-to-br from-brand-dark via-deep-blue to-brand-dark pt-20 pb-24 overflow-hidden">
        <!-- Animated Background Patterns -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        </div>
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/islamic-art.png')] opacity-5"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 animate-fade-in">
                <span class="inline-block px-4 py-1.5 rounded-full bg-accent-DEFAULT/20 text-accent-amber text-xs font-bold uppercase tracking-widest mb-4 border border-accent-DEFAULT/30 backdrop-blur-sm">
                    {{ __('services.all_categories') }}
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">
                    {{ __('services.hero_title') }}
                </h1>
                <p class="text-xl text-white/70 max-w-2xl mx-auto font-medium">
                    {{ __('services.hero_description') }}
                </p>
            </div>

            <!-- MAIN CATEGORY GROUPS GRID -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
                <template x-for="group in browserData" :key="group.key">
                    <button @click="openGroup(group.key)"
                        class="group relative bg-white/5 backdrop-blur-md rounded-3xl p-6 text-center border border-white/10 hover:border-accent-DEFAULT/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-accent-DEFAULT/20 overflow-hidden">
                        
                        {{-- Hover Gradient Glow --}}
                        <div class="absolute -inset-full bg-gradient-to-br from-transparent via-white/5 to-transparent group-hover:animate-shimmer pointer-events-none"></div>
                        
                        {{-- Icon Wrapper --}}
                        <div :class="`w-20 h-20 mx-auto mb-4 rounded-2xl bg-gradient-to-br ${group.gradient} flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-500` shadow-gold/20">
                            <span class="text-5xl group-hover:animate-bounce-subtle" x-text="group.emoji"></span>
                        </div>
                        
                        <h3 class="text-white font-bold text-base md:text-lg mb-1 group-hover:text-accent-amber transition-colors" x-text="group.name"></h3>
                        <p class="text-white/40 text-xs font-medium uppercase tracking-wider" x-text="group.categories.length + ' {{ __('services.list_title') }}'"></p>
                    </button>
                </template>
            </div>

            {{-- Floating Search Bar --}}
            <div class="max-w-3xl mx-auto mt-16 scale-105">
                <form action="{{ route('services.index') }}" method="GET" class="relative group">
                    <div class="flex items-center bg-white rounded-2xl shadow-2xl overflow-hidden p-1 border-4 border-white/10 group-focus-within:border-accent-DEFAULT/30 transition-all duration-300">
                        <div class="flex-1 relative pl-6 flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="w-full px-4 py-4 bg-transparent border-0 focus:ring-0 text-gray-800 placeholder:text-gray-400 text-lg font-medium"
                                placeholder="{{ __('services.search_placeholder') }}" />
                        </div>
                        <button type="submit"
                            class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-DEFAULT text-white font-bold text-lg rounded-xl transition-all duration-300 shadow-lg">
                            {{ __('services.search_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN BROWSER CONTENT (Visible after search or scroll) -->
    <div class="container mx-auto px-4 py-16">
        @if(request('q'))
            <div class="mb-12">
                <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-3xl font-bold text-brand-dark">
                        {{ __('services.showing_results', ['count' => $services->total()]) }}
                    </h2>
                    <a href="{{ route('services.index') }}" class="text-accent-DEFAULT hover:underline font-bold text-sm">
                        {{ __('services.view_all_services') }}
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($services as $svc)
                        <a href="{{ route('services.show', $svc->slug) }}" class="group bg-white rounded-3xl p-6 shadow-soft hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-accent-DEFAULT/20">
                            <div class="flex items-start gap-4 mb-4">
                                <x-service-icon :category="$svc->category" size="md" />
                                <div>
                                    <h4 class="font-bold text-brand-dark group-hover:text-accent-DEFAULT transition-colors" x-text="'{{ $svc->localized_name }}'"></h4>
                                    <span class="text-xs text-gray-400 font-medium uppercase tracking-tight">{{ $svc->category->localized_name }}</span>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $svc->localized_summary }}</p>
                            <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-accent-DEFAULT font-bold text-xs uppercase">{{ __('services.view_details') }}</span>
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-accent-DEFAULT group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="text-6xl mb-6">🏜️</div>
                            <h3 class="text-2xl font-bold text-brand-dark mb-2">{{ __('services.no_results') }}</h3>
                            <p class="text-gray-500 mb-8">{{ __('services.no_results_desc') }}</p>
                            <a href="{{ route('services.index') }}" class="btn-accent">{{ __('services.view_all') }}</a>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-12">
                    {{ $services->links() }}
                </div>
            </div>
        @endif

        {{-- Groups & Categories list if no search --}}
        @if(!request('q'))
            <div class="mb-12">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-4xl font-bold text-brand-dark mb-4">{{ __('services.all_categories') }}</h2>
                    <p class="text-gray-500">{{ __('services.hero_description') }}</p>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach($browserData as $group)
                        @foreach($group['categories'] as $cat)
                            <button @click="openCategory({{ $cat['id'] }}); selectedGroup = '{{ $group['key'] }}'"
                                class="group flex flex-col items-center p-8 bg-white hover:bg-accent-DEFAULT/5 rounded-[2.5rem] transition-all duration-500 shadow-soft hover:shadow-2xl border border-transparent hover:border-accent-DEFAULT/20">
                                <div class="w-20 h-20 rounded-3xl bg-gray-50 shadow-inner flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                    <x-service-icon :category="$cat['slug']" size="lg" />
                                </div>
                                <span class="text-base font-bold text-gray-800 group-hover:text-accent-DEFAULT text-center transition-colors">
                                    {{ $cat['name'] }}
                                </span>
                                <span class="mt-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ count($cat['services']) }} {{ __('services.services') }}</span>
                            </button>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- ============= ENHANCED HIERARCHICAL MODAL BROWSER ============= -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="closeModal()"
        class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-brand-dark/80 backdrop-blur-sm"
        style="display:none">

        <!-- Close button mobile -->
        <button @click="closeModal()" class="absolute top-6 right-6 text-white/50 hover:text-white sm:hidden">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95"
            @click.away="closeModal()"
            class="bg-white rounded-t-[3rem] sm:rounded-[3rem] shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden max-h-[95vh] sm:max-h-[85vh]">

            <!-- Modal Header -->
            <div class="relative px-8 py-8 border-b border-gray-100 flex-shrink-0 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center gap-6">
                    <button x-show="step !== 'groups'" @click="goBack()"
                        class="w-12 h-12 flex items-center justify-center bg-white rounded-2xl shadow-md border border-gray-100 text-gray-500 hover:text-accent-DEFAULT hover:shadow-lg transition-all">
                        <svg class="w-6 h-6 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-2 text-xs font-black text-accent-DEFAULT uppercase tracking-widest mb-1">
                            <span x-text="step === 'groups' ? '{{ __('services.explore') }}' : (currentGroup ? currentGroup.name : '')"></span>
                            <span x-show="selectedCategory" class="mx-1 text-gray-300">•</span>
                            <span x-show="selectedCategory" x-text="currentCategory ? currentCategory.name : ''"></span>
                        </div>
                        <h2 class="text-3xl font-black text-brand-dark"
                            x-text="step === 'groups' ? '{{ __('services.hero_title') }}' : step === 'categories' ? '{{ __('services.choose_category') }}' : '{{ __('services.choose_service') }}'">
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Scrollable List Body -->
            <div class="overflow-y-auto flex-1 px-8 py-8 custom-scrollbar">

                <!-- STEP 1: GROUPS -->
                <div x-show="step === 'groups'" class="grid grid-cols-1 sm:grid-cols-2 gap-4 animate-slide-up">
                    <template x-for="group in browserData" :key="group.key">
                        <button @click="openGroup(group.key)"
                            class="flex items-center gap-6 p-6 rounded-3xl border-2 border-gray-100 hover:border-accent-DEFAULT hover:bg-accent-DEFAULT/5 transition-all text-left group">
                            <div :class="`w-16 h-16 rounded-2xl bg-gradient-to-br ${group.gradient} flex items-center justify-center text-4xl shadow-lg shadow-gold/10`">
                                <span x-text="group.emoji"></span>
                            </div>
                            <div class="flex-1 text-left">
                                <div class="font-bold text-xl text-gray-800 group-hover:text-accent-DEFAULT" x-text="group.name"></div>
                                <div class="text-sm text-gray-400 font-medium" x-text="group.categories.length + ' {{ __('services.list_title') }}'"></div>
                            </div>
                            <svg class="w-6 h-6 text-gray-300 group-hover:text-accent-DEFAULT transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </template>
                </div>

                <!-- STEP 2: CATEGORIES -->
                <div x-show="step === 'categories'" class="space-y-4 animate-slide-up">
                    <template x-show="currentGroup" x-for="cat in (currentGroup ? currentGroup.categories : [])" :key="cat.id">
                        <button @click="openCategory(cat.id)"
                            class="w-full flex items-center gap-6 p-6 rounded-3xl border-2 border-gray-100 hover:border-accent-DEFAULT hover:bg-accent-DEFAULT/5 transition-all group">
                            <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center p-3 group-hover:bg-white shadow-inner group-hover:shadow-lg transition-all">
                                <img :src="`https://api.dicebear.com/7.x/shapes/svg?seed=${cat.slug}&backgroundColor=transparent`" class="w-10 h-10" />
                            </div>
                            <div class="flex-1 text-left">
                                <div class="font-bold text-xl text-gray-800 group-hover:text-accent-DEFAULT" x-text="cat.name"></div>
                                <div class="text-sm text-gray-400 font-medium" x-text="cat.services.length + ' {{ __('services.subservices_available') }}'"></div>
                            </div>
                            <svg class="w-6 h-6 text-gray-300 group-hover:text-accent-DEFAULT transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </template>
                </div>

                <!-- STEP 3: SERVICES (FLOATING LIST STYLE) -->
                <div x-show="step === 'services'" class="grid grid-cols-1 gap-4 animate-fade-in">
                    <template x-show="currentCategory" x-for="svc in (currentCategory ? currentCategory.services : [])" :key="svc.id">
                        <a :href="'/services/' + svc.slug"
                            class="flex items-center gap-6 p-8 rounded-[2rem] bg-gradient-to-br from-gray-50 to-white hover:from-accent-DEFAULT hover:to-accent-amber transition-all duration-300 group shadow-sm hover:shadow-2xl hover:-translate-y-1 border border-gray-100 hover:border-transparent">
                            <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center text-accent-DEFAULT shadow-md transition-transform group-hover:scale-110">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <div class="font-bold text-xl text-brand-dark group-hover:text-white transition-colors" x-text="svc.name"></div>
                                <div class="text-sm text-gray-500 group-hover:text-white/80 transition-colors line-clamp-1" x-text="svc.summary"></div>
                            </div>
                            <div class="bg-accent-amber/20 group-hover:bg-white/20 p-3 rounded-xl transition-colors">
                                <svg class="w-6 h-6 text-accent-DEFAULT group-hover:text-white transform group-hover:translate-x-2 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </a>
                    </template>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                <span>KairouanHub Navigation Engine</span>
                <div class="flex gap-1">
                    <div :class="`w-2 h-2 rounded-full ${step === 'groups' ? 'bg-accent-DEFAULT' : 'bg-gray-200'}`"></div>
                    <div :class="`w-2 h-2 rounded-full ${step === 'categories' ? 'bg-accent-DEFAULT' : 'bg-gray-200'}`"></div>
                    <div :class="`w-2 h-2 rounded-full ${step === 'services' ? 'bg-accent-DEFAULT' : 'bg-gray-200'}`"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-black text-brand-dark mb-6">
                {{ __('services.cta_title') }}
            </h2>
            <p class="text-xl text-gray-500 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ __('services.cta_desc') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('requests.create') }}"
                    class="w-full sm:w-auto px-12 py-5 bg-brand-dark text-white font-black text-lg rounded-[2rem] shadow-2xl hover:bg-accent-DEFAULT hover:shadow-gold/30 hover:scale-105 transition-all duration-500">
                    {{ __('home.request_service') }}
                </a>
                <a href="{{ route('home') }}"
                    class="w-full sm:w-auto px-12 py-5 bg-white border-4 border-gray-100 text-brand-dark font-black text-lg rounded-[2rem] hover:border-accent-DEFAULT hover:text-accent-DEFAULT transition-all duration-500">
                    {{ __('services.cta_button') }}
                </a>
            </div>
        </div>
    </div>

    </div>{{-- end outer Alpine.js x-data wrapper --}}

    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(200%) rotate(45deg); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite ease-out;
            width: 50%;
            height: 300%;
        }
        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0) scale(1.1); }
            50% { transform: translateY(-5px) scale(1.1); }
        }
        .animate-bounce-subtle {
            animation: bounce-subtle 2s infinite ease-in-out;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
        [dir="rtl"] .group-hover\:translate-x-1 {
            --tw-translate-x: -0.25rem !important;
        }
        [dir="rtl"] .group-hover\:translate-x-2 {
            --tw-translate-x: -0.5rem !important;
        }
    </style>
@endsection