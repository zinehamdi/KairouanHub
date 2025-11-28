@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-kairouan-beige/30 via-amber-50 to-accent-copper/20 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-flash />

            @if($profile)
                <!-- Header -->
                <div class="mb-8">
                    <h1
                        class="text-4xl font-extrabold bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-accent-copper bg-clip-text text-transparent mb-2">
                        {{ __('dashboard.welcome', ['name' => $profile->display_name]) }}
                    </h1>
                    <p class="text-lg text-gray-600">{{ __('dashboard.manage_profile') }}</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-accent-DEFAULT to-accent-amber rounded-2xl p-6 text-white shadow-lg">
                        <div class="text-sm font-bold uppercase tracking-wider opacity-90 mb-1">
                            {{ __('dashboard.stats.services_offered') }}</div>
                        <div class="text-4xl font-extrabold mb-1">{{ $profile->services->count() }}</div>
                        <div class="text-sm opacity-90">{{ __('dashboard.stats.active_services') }}</div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-accent-copper rounded-2xl p-6 text-white shadow-lg">
                        <div class="text-sm font-bold uppercase tracking-wider opacity-90 mb-1">
                            {{ __('dashboard.stats.completed_jobs') }}</div>
                        <div class="text-4xl font-extrabold mb-1">{{ $profile->completed_jobs }}</div>
                        <div class="text-sm opacity-90">{{ __('dashboard.stats.successful_deliveries') }}</div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg">
                        <div class="text-sm font-bold uppercase tracking-wider opacity-90 mb-1">
                            {{ __('dashboard.stats.average_rating') }}</div>
                        <div class="text-4xl font-extrabold mb-1">{{ $profile->avg_rating ?? 'N/A' }}</div>
                        <div class="text-sm opacity-90">{{ __('dashboard.stats.out_of') }}</div>
                    </div>
                </div>

                <!-- Main Content with Sidebar -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8" x-data="{ activeTab: 'profile' }">
                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-4 sticky top-24">
                            <nav class="space-y-2">
                                <button @click="activeTab = 'profile'"
                                    :class="activeTab === 'profile' ? 'bg-accent-DEFAULT text-white' : 'text-gray-700 hover:bg-gray-100'"
                                    class="w-full text-left px-4 py-3 rounded-xl font-semibold transition-all flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('dashboard.sidebar.profile') }}
                                </button>
                                <button @click="activeTab = 'services'"
                                    :class="activeTab === 'services' ? 'bg-accent-DEFAULT text-white' : 'text-gray-700 hover:bg-gray-100'"
                                    class="w-full text-left px-4 py-3 rounded-xl font-semibold transition-all flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('dashboard.sidebar.services') }}
                                </button>
                                <button @click="activeTab = 'gallery'"
                                    :class="activeTab === 'gallery' ? 'bg-accent-DEFAULT text-white' : 'text-gray-700 hover:bg-gray-100'"
                                    class="w-full text-left px-4 py-3 rounded-xl font-semibold transition-all flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('dashboard.sidebar.gallery') }}
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="lg:col-span-3">
                        <!-- Profile Tab -->
                        <div x-show="activeTab === 'profile'" x-transition class="bg-white rounded-2xl shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('dashboard.profile.title') }}</h2>

                            <!-- Avatar Section -->
                            <div class="mb-8 pb-8 border-b border-gray-200">
                                <label
                                    class="block text-sm font-bold text-gray-700 mb-3">{{ __('dashboard.profile.profile_photo') }}</label>
                                <div class="flex items-center gap-6">
                                    <img src="{{ $profile->avatar_url }}" alt="Profile"
                                         class="w-24 h-24 rounded-full object-cover border-4 border-accent-amber shadow-lg">
                                    <form action="{{ route('provider.avatar.update') }}" method="POST"
                                        enctype="multipart/form-data" class="flex-1">
                                        @csrf
                                        <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent-DEFAULT file:text-white hover:file:bg-accent-amber transition-all mb-2">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all text-sm">
                                            {{ __('dashboard.profile.upload_photo') }}
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Profile Form -->
                            <form action="{{ route('provider.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $profile->category_id }}">

                                <div>
                                    <label for="display_name"
                                        class="block text-sm font-bold text-gray-700 mb-2">{{ __('dashboard.profile.display_name') }}</label>
                                    <input type="text" name="display_name" id="display_name"
                                        value="{{ $profile->display_name }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
                                </div>

                                <div>
                                    <label for="city"
                                        class="block text-sm font-bold text-gray-700 mb-2">{{ __('dashboard.profile.location') }}</label>
                                    <input type="text" name="city" id="city" value="{{ $profile->city }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
                                </div>

                                <div>
                                    <label for="bio"
                                        class="block text-sm font-bold text-gray-700 mb-2">{{ __('dashboard.profile.about') }}</label>
                                    <textarea name="bio" id="bio" rows="4"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all"
                                        placeholder="{{ __('dashboard.profile.bio_placeholder') }}">{{ $profile->bio }}</textarea>
                                </div>

                                <div>
                                    <label for="website"
                                        class="block text-sm font-bold text-gray-700 mb-2">{{ __('dashboard.profile.website') }}</label>
                                    <input type="url" name="website" id="website" value="{{ $profile->website }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
                                </div>

                                <button type="submit"
                                    class="w-full py-3 px-6 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                    {{ __('dashboard.profile.save_changes') }}
                                </button>
                            </form>
                        </div>

                        <!-- Services Tab -->
                        <div x-show="activeTab === 'services'" x-transition class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ __('dashboard.services.title') }}</h2>
                                <a href="{{ route('provider.services') }}"
                                    class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all text-sm">
                                    {{ __('dashboard.services.edit_services') }}
                                </a>
                            </div>

                            @if($profile->services->count() > 0)
                                <div class="grid gap-4">
                                    @foreach($profile->services as $svc)
                                        <div
                                            class="flex items-center justify-between p-5 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-accent-amber/30 hover:border-accent-amber transition-all">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white text-xl font-bold shadow-lg">
                                                    {{ substr($svc->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-lg font-bold text-gray-900">{{ $svc->name }}</div>
                                                    @if($svc->pivot->price_min || $svc->pivot->price_max)
                                                        <div class="text-base font-semibold text-green-600">
                                                            {{ $svc->pivot->price_min ?? 0 }} - {{ $svc->pivot->price_max ?? 0 }} TND
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium mb-4">{{ __('dashboard.services.no_services') }}</p>
                                    <a href="{{ route('provider.services') }}"
                                        class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                        {{ __('dashboard.services.add_service') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Gallery Tab -->
                        <div x-show="activeTab === 'gallery'" x-transition class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ __('dashboard.gallery.title') }}</h2>
                                <a href="{{ route('provider.photos') }}"
                                    class="px-4 py-2 bg-gradient-to-r from-accent-copper to-orange-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all text-sm">
                                    {{ __('dashboard.gallery.manage_photos') }}
                                </a>
                            </div>

                            @if($profile->photos_json && count($profile->photos_json) > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($profile->photos_json as $photo)
                                        <div
                                            class="relative group overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all">
                                            <img src="{{ Storage::url($photo) }}" class="w-full h-48 object-cover" alt="Portfolio">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium mb-4">{{ __('dashboard.gallery.no_photos') }}</p>
                                    <a href="{{ route('provider.photos') }}"
                                        class="inline-block px-6 py-3 bg-gradient-to-r from-accent-copper to-orange-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                        {{ __('dashboard.gallery.upload_photos') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-2xl p-12 text-center">
                    <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-700 mb-4">{{ __('dashboard.messages.no_profile') }}</h2>
                    <p class="text-xl text-gray-600 mb-8">{{ __('dashboard.messages.no_profile_text') }}</p>
                    <a href="{{ route('provider.start') }}"
                        class="inline-block px-10 py-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold text-xl rounded-2xl shadow-2xl hover:shadow-accent-amber/50 transition-all transform hover:scale-105">
                        {{ __('dashboard.messages.create_now') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection