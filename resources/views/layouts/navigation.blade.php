<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-white/20 shadow-lg" style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
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
                    <x-nav-link :href="route('providers.index')" :active="request()->routeIs('providers.*')"
                        class="text-base font-medium">
                        {{ __('nav.providers') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.index')"
                            class="text-base font-medium">
                            {{ __('Browse Requests') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                            class="text-base font-medium">
                            {{ __('nav.dashboard') }}
                        </x-nav-link>
                    @endauth

                    <!-- Become a Provider Button -->
                    @auth
                        @if(!auth()->user()->providerProfile)
                            <a href="{{ route('provider.start') }}"
                                class="inline-flex items-center px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg shadow-md transition-all duration-200 hover:shadow-lg backdrop-blur-sm border border-white/30">
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
                            class="inline-flex items-center px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg shadow-md transition-all duration-200 hover:shadow-lg backdrop-blur-sm border border-white/30">
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
                        class="inline-flex items-center px-3 py-2 border border-white/30 text-sm font-medium rounded-lg text-white bg-white/10 hover:bg-white/20 transition backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-1.5 rtl:ml-1.5 rtl:mr-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
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
                                class="inline-flex items-center px-4 py-2 border-2 border-white/30 text-sm font-medium rounded-xl text-white bg-white/10 hover:bg-white/20 focus:outline-none transition ease-in-out duration-150 backdrop-blur-sm">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white/30 backdrop-blur-sm flex items-center justify-center text-white font-bold shadow-lg">
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

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
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
                            <a href="{{ route('register') }}" class="text-sm px-6 py-2.5 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg shadow-md transition-all duration-200 hover:shadow-lg backdrop-blur-sm border border-white/30">
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
            <x-responsive-nav-link :href="route('providers.index')" :active="request()->routeIs('providers.*')">
                {{ __('nav.providers') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('nav.dashboard') }}
                </x-responsive-nav-link>
            @endauth
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

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
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