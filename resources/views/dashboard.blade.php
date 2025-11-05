<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-accent-DEFAULT to-accent-amber p-1 rounded-lg">
            <div class="bg-white px-6 py-4 rounded-lg">
                <h2 class="font-bold text-2xl text-brand-dark">
                    {{ __('Dashboard') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-neutral-light to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="mb-8 bg-gradient-to-br from-accent-DEFAULT to-accent-amber p-1 rounded-2xl shadow-2xl">
                <div class="bg-white p-8 rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold text-brand-dark mb-2">
                                {{ __('dashboard.welcome', ['مرحباً']) }} {{ auth()->user()->name }}!
                            </h3>
                            <p class="text-brand-dark/70 text-lg">
                                {{ __("You're logged in!") }}
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center shadow-xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Request Service -->
                <a href="{{ route('requests.create') }}" class="group bg-gradient-to-br from-neutral-light to-white p-6 rounded-xl shadow-xl hover:shadow-2xl border-2 border-accent-DEFAULT/20 hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-dark mb-2 group-hover:text-accent-DEFAULT transition-colors duration-300">
                        {{ __('dashboard.request_service', ['اطلب خدمة']) }}
                    </h4>
                    <p class="text-brand-dark/70">
                        {{ __('dashboard.request_service_desc', ['ابدأ طلب خدمة جديد']) }}
                    </p>
                </a>

                <!-- My Requests -->
                <a href="{{ route('requests.mine') }}" class="group bg-gradient-to-br from-neutral-light to-white p-6 rounded-xl shadow-xl hover:shadow-2xl border-2 border-accent-DEFAULT/20 hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-dark mb-2 group-hover:text-accent-DEFAULT transition-colors duration-300">
                        {{ __('dashboard.my_requests', ['طلباتي']) }}
                    </h4>
                    <p class="text-brand-dark/70">
                        {{ __('dashboard.my_requests_desc', ['عرض جميع طلباتك']) }}
                    </p>
                </a>

                <!-- Browse Services -->
                <a href="{{ route('services.index') }}" class="group bg-gradient-to-br from-neutral-light to-white p-6 rounded-xl shadow-xl hover:shadow-2xl border-2 border-accent-DEFAULT/20 hover:border-accent-DEFAULT/40 transition-all duration-300 hover:-translate-y-2">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-brand-dark mb-2 group-hover:text-accent-DEFAULT transition-colors duration-300">
                        {{ __('dashboard.browse_services', ['تصفح الخدمات']) }}
                    </h4>
                    <p class="text-brand-dark/70">
                        {{ __('dashboard.browse_services_desc', ['اكتشف الخدمات المتاحة']) }}
                    </p>
                </a>
            </div>

            <!-- Become Provider CTA -->
            @if(!auth()->user()->providerProfile)
            <div class="bg-gradient-to-r from-accent-DEFAULT to-accent-amber p-1 rounded-2xl shadow-2xl">
                <div class="bg-white p-8 rounded-2xl text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber mb-6 shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-brand-dark mb-4">
                        {{ __('dashboard.become_provider', ['كن مقدم خدمة']) }}
                    </h3>
                    <p class="text-brand-dark/70 mb-6 max-w-2xl mx-auto text-lg">
                        {{ __('dashboard.become_provider_desc', ['انضم إلى شبكة المحترفين في القيروان واحصل على المزيد من العملاء']) }}
                    </p>
                    <a href="{{ route('provider.start') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-xl rounded-lg shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                        {{ __('dashboard.start_now', ['ابدأ الآن']) }}
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
