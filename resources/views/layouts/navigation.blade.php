<nav x-data="{ open: false, howOpen: false }" class="sticky top-0 z-50 border-b border-white/10 shadow-xl"
    style="background: linear-gradient(135deg, #1A2332 0%, #0F1419 100%);">

    <!-- Luxurious How It Works Modal -->
    <div x-show="howOpen"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 backdrop-blur-0"
        x-transition:enter-end="opacity-100 backdrop-blur-md"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 backdrop-blur-md"
        x-transition:leave-end="opacity-0 backdrop-blur-0"
        @click.self="howOpen = false"
        @keydown.escape.window="howOpen = false"
        class="fixed inset-0 bg-brand-dark/95 z-[100] flex items-center justify-center p-4 sm:p-6"
        style="display:none">
        
        <div x-show="howOpen"
            x-transition:enter="transition ease-out duration-500 delay-100"
            x-transition:enter-start="opacity-0 translate-y-20 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-20 scale-90"
            class="bg-white rounded-[3rem] shadow-[0_0_100px_rgba(0,0,0,0.5)] w-full max-w-2xl overflow-hidden relative border border-white/20"
            style="display:none">
            
            <!-- Close Button -->
            <button @click="howOpen = false" 
                class="absolute top-6 right-6 z-10 w-12 h-12 bg-gray-100 hover:bg-brand-dark hover:text-white rounded-2xl flex items-center justify-center transition-all transform hover:rotate-90">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="relative">
                <!-- Decorative element -->
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-accent-DEFAULT/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-accent-amber/10 rounded-full blur-3xl"></div>

                <div class="px-10 py-12 relative z-10">
                    <div class="text-center mb-12">
                        <span class="inline-block px-4 py-1.5 bg-accent-DEFAULT/10 text-accent-DEFAULT rounded-full text-xs font-black uppercase tracking-widest mb-4">Discover the Hub</span>
                        <h2 class="text-4xl font-black text-brand-dark tracking-tighter">{{ __('nav.how_it_works') }}</h2>
                    </div>

                    <div class="space-y-10">
                        <!-- Step 1 -->
                        <div class="flex items-start gap-8 group">
                            <div class="relative shrink-0">
                                <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-brand-dark to-brand-DEFAULT flex items-center justify-center text-white font-black text-2xl shadow-2xl relative z-10 group-hover:scale-110 transition-transform duration-500">1</div>
                                <div class="absolute -inset-2 bg-accent-DEFAULT/20 rounded-[2rem] blur-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="pt-2">
                                <h3 class="font-black text-brand-dark text-xl mb-2 group-hover:text-accent-DEFAULT transition-colors">{{ __('nav.how_step1_title') }}</h3>
                                <p class="text-gray-500 text-lg leading-relaxed font-medium">{{ __('nav.how_step1_desc') }}</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-start gap-8 group">
                            <div class="relative shrink-0">
                                <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white font-black text-2xl shadow-2xl relative z-10 group-hover:scale-110 transition-transform duration-500">2</div>
                                <div class="absolute -inset-2 bg-accent-amber/20 rounded-[2rem] blur-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="pt-2">
                                <h3 class="font-black text-brand-dark text-xl mb-2 group-hover:text-accent-amber transition-colors">{{ __('nav.how_step2_title') }}</h3>
                                <p class="text-gray-500 text-lg leading-relaxed font-medium">{{ __('nav.how_step2_desc') }}</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex items-start gap-8 group">
                            <div class="relative shrink-0">
                                <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-accent-amber to-accent-copper flex items-center justify-center text-white font-black text-2xl shadow-2xl relative z-10 group-hover:scale-110 transition-transform duration-500">3</div>
                                <div class="absolute -inset-2 bg-accent-copper/20 rounded-[2rem] blur-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="pt-2">
                                <h3 class="font-black text-brand-dark text-xl mb-2 group-hover:text-accent-copper transition-colors">{{ __('nav.how_step3_title') }}</h3>
                                <p class="text-gray-500 text-lg leading-relaxed font-medium">{{ __('nav.how_step3_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 flex flex-col sm:flex-row gap-5">
                        <a href="{{ route('services.index') }}" @click="howOpen = false"
                            class="flex-[2] text-center py-5 bg-brand-dark text-white font-black rounded-2xl shadow-2xl hover:bg-accent-DEFAULT hover:text-brand-dark transition-all transform hover:-translate-y-1 active:scale-95">
                            {{ __('nav.how_cta') }}
                        </a>
                        <a href="{{ route('provider.start') }}" @click="howOpen = false"
                            class="flex-1 text-center py-5 bg-gray-100 text-brand-dark font-black rounded-2xl border-2 border-transparent hover:border-gray-200 transition-all hover:bg-white active:scale-95">
                            {{ __('nav.how_provider_cta') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                        <img src="{{ asset('images/kairouanhubLogo.PNG') }}" alt="KairouanHub Logo"
                            class="h-12 w-auto group-hover:scale-105 transition-transform duration-300">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 rtl:space-x-reverse sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                        class="text-base font-medium">
                        {{ __('nav.home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')"
                        class="text-base font-medium">
                        {{ __('nav.services') }}
                    </x-nav-link>
                    <button @click="howOpen = true"
                        class="inline-flex items-center px-3 py-1.5 text-base font-medium text-white hover:text-white/80 transition-colors">
                        <svg class="w-4 h-4 me-1.5 rtl:ms-1.5 rtl:me-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('nav.how_it_works') }}
                    </button>
                    @auth
                        <x-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.index')"
                            class="text-base font-medium">
                            {{ __('nav.browse_requests') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                            class="text-base font-medium">
                            {{ __('nav.dashboard') }}
                        </x-nav-link>
                    @endauth

                    {{-- Become a Provider Button - Hide for admins/superadmins/existing providers --}}
                    @auth
                        @if(!auth()->user()->hasRole(['admin', 'superadmin']) && !auth()->user()->providerProfile)
                            <a href="{{ route('provider.start') }}"
                                class="inline-flex items-center px-4 py-2.5 bg-white/30 hover:bg-white/40 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl backdrop-blur-md border-2 border-white/40">
                                <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('nav.become_provider') }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('provider.start') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-white/30 hover:bg-white/40 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl backdrop-blur-md border-2 border-white/40">
                            <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ __('nav.become_provider') }}
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <!-- Language Switcher -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center px-3 py-2 border-2 border-white/40 text-sm font-bold rounded-lg text-white bg-white/20 hover:bg-white/30 transition backdrop-blur-md">
                        <svg class="w-5 h-5 mr-1.5 rtl:ml-1.5 rtl:mr-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="hidden md:inline">{{ strtoupper(app()->getLocale()) }}</span>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 rtl:left-0 rtl:right-auto mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                        <a href="{{ route('lang.switch', 'ar') }}"
                            class="flex items-center px-4 py-2 text-sm hover:bg-kairouan-warm-cream transition @if(app()->getLocale() === 'ar') bg-kairouan-warm-cream font-semibold @endif">
                            <span class="mr-2 rtl:ml-2 rtl:mr-0">🇹🇳</span> العربية
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="flex items-center px-4 py-2 text-sm hover:bg-kairouan-warm-cream transition @if(app()->getLocale() === 'en') bg-kairouan-warm-cream font-semibold @endif">
                            <span class="mr-2 rtl:ml-2 rtl:mr-0">🇬🇧</span> English
                        </a>
                        <a href="{{ route('lang.switch', 'fr') }}"
                            class="flex items-center px-4 py-2 text-sm hover:bg-kairouan-warm-cream transition @if(app()->getLocale() === 'fr') bg-kairouan-warm-cream font-semibold @endif">
                            <span class="mr-2 rtl:ml-2 rtl:mr-0">🇫🇷</span> Français
                        </a>
                    </div>
                </div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 border-2 border-white/40 text-sm font-bold rounded-xl text-white bg-white/20 hover:bg-white/30 focus:outline-none transition ease-in-out duration-150 backdrop-blur-md shadow-lg">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white/40 backdrop-blur-md flex items-center justify-center text-white font-black shadow-inner">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span>{{ Auth::user()->name }}</span>
                                </div>

                                <div class="ms-2 rtl:mr-2 rtl:ms-0">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(auth()->user()->hasRole('admin'))
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    🛡️ {{ __('nav.admin_dashboard') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                👤 {{ __('nav.profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                                                                        this.closest('form').submit();">
                                    🚪 {{ __('nav.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-white/90 hover:text-white transition-colors duration-300 px-4 py-2 rounded-lg hover:bg-white/10">
                            {{ __('nav.login') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-sm px-6 py-2.5 bg-white/30 hover:bg-white/40 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl backdrop-blur-md border-2 border-white/40">
                                {{ __('nav.register') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-white/90 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-gradient-to-b from-transparent to-black/10">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('nav.home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                {{ __('nav.services') }}
            </x-responsive-nav-link>
            <button @click="howOpen = true; open = false"
                class="w-full text-start flex items-center gap-2 px-4 py-2 text-white/90 hover:bg-white/10 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('nav.how_it_works') }}
            </button>
            @auth
                <x-responsive-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.index')">
                    {{ __('nav.browse_requests') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('nav.dashboard') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Language Switcher (Mobile) -->
        <div class="pt-4 pb-3 border-t border-white/20 bg-gradient-to-b from-transparent to-black/10">
            <div class="px-4">
                <div class="text-sm font-medium text-white/70 mb-2">{{ __('common.language') }}</div>
                <div class="space-y-1">
                    <a href="{{ route('lang.switch', 'ar') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-white transition @if(app()->getLocale() === 'ar') bg-white/20 font-semibold @else hover:bg-white/10 @endif">
                        <span class="mr-2 rtl:ml-2 rtl:mr-0">🇹🇳</span> العربية
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-white transition @if(app()->getLocale() === 'en') bg-white/20 font-semibold @else hover:bg-white/10 @endif">
                        <span class="mr-2 rtl:ml-2 rtl:mr-0">🇬🇧</span> English
                    </a>
                    <a href="{{ route('lang.switch', 'fr') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-white transition @if(app()->getLocale() === 'fr') bg-white/20 font-semibold @else hover:bg-white/10 @endif">
                        <span class="mr-2 rtl:ml-2 rtl:mr-0">🇫🇷</span> Français
                    </a>
                </div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-white/20 bg-gradient-to-b from-transparent to-black/10">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white/70">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(auth()->user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('admin.dashboard')">
                            🛡️ {{ __('nav.admin_dashboard') }}
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')">
                        👤 {{ __('nav.profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                                                                                this.closest('form').submit();">
                            🚪 {{ __('nav.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-white/20 bg-gradient-to-b from-transparent to-black/10">
                <div class="px-4 space-y-2">
                    <x-responsive-nav-link :href="route('login')">{{ __('nav.login') }}</x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">{{ __('nav.register') }}</x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endauth
    </div>
</nav>