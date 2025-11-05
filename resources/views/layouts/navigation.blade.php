<nav x-data="{ open: false }" class="nav-kairouan sticky top-0 z-50" style="background: linear-gradient(to right, rgba(160, 137, 112, 0.95), rgba(245, 241, 232, 0.95)); backdrop-filter: blur(10px);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex items-center">
                <!-- Logo with Kairouan Design -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse group">
                        <img src="{{ asset('images/kairouanhubLogo.PNG') }}" 
                             alt="KairouanHub Logo" 
                             class="h-14 w-auto drop-shadow-lg group-hover:scale-105 transition-transform duration-300">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 rtl:space-x-reverse sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-lg">
                        Home
                    </x-nav-link>
                    <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')" class="text-lg">
                        Services
                    </x-nav-link>
                    <x-nav-link :href="route('providers.index')" :active="request()->routeIs('providers.*')" class="text-lg">
                        Providers
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings / Auth Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4 rtl:space-x-reverse">
                {{-- Language Switcher --}}
                <div class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/50 backdrop-blur-sm border border-accent-DEFAULT/20">
                    <button class="px-3 py-1 text-sm font-bold text-gray-900 hover:text-accent-DEFAULT transition-colors duration-300">
                        EN
                    </button>
                    <span class="text-gray-400">|</span>
                    <button class="px-3 py-1 text-sm font-bold text-gray-900 hover:text-accent-DEFAULT transition-colors duration-300">
                        عربي
                    </button>
                </div>
                
                {{-- Provider CTA EN/AR --}}
                @php($user = auth()->user())
                @if(!$user)
                    <a href="{{ route('provider.start') }}" class="px-5 py-2.5 rounded-lg text-sm font-bold bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                        Become Provider
                    </a>
                @else
                    @if(!$user->providerProfile)
                        <a href="{{ route('provider.start') }}" class="px-5 py-2.5 rounded-lg text-sm font-bold bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                            Become Provider
                        </a>
                    @else
                        <a href="{{ route('provider.dashboard') }}" class="px-5 py-2.5 rounded-lg text-sm font-bold bg-white border-2 border-accent-DEFAULT text-brand-dark hover:bg-accent-DEFAULT hover:text-white shadow-lg transition-all duration-300">
                            Provider Dashboard
                        </a>
                    @endif
                @endif
                
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-kairouan-beige/20 dark:border-kairouan-gold/20 text-sm leading-4 font-medium rounded-kairouan text-kairouan-brown dark:text-kairouan-gold bg-white dark:bg-kairouan-black/50 hover:bg-kairouan-beige/50 dark:hover:bg-kairouan-gold/10 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4 rtl:space-x-reverse flex items-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-kairouan-brown dark:text-kairouan-gold hover:text-kairouan-gold transition-colors duration-300">
                            {{ __('Log in') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-kairouan text-sm font-medium bg-gradient-to-r from-kairouan-gold to-kairouan-amber text-white shadow-brass hover:shadow-gold hover:scale-105 transition-all duration-300">
                                {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <x-responsive-nav-link :href="route('login')">{{ __('Log in') }}</x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
                    @endif
                </div>
            </div>
        @endauth
    </div>
</nav>
