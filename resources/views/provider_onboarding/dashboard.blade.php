@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-kairouan-beige/30 via-amber-50 to-accent-copper/20 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-flash />
        
        @if($profile)
            <!-- Header Section with Status Badge -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-accent-copper bg-clip-text text-transparent mb-2">
                            Welcome back, {{ $profile->display_name }}! 👋
                        </h1>
                        <p class="text-xl text-gray-600 font-medium">Manage your profile and services</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($profile->status === 'approved')
                            <div class="px-6 py-3 rounded-2xl bg-gradient-to-r from-green-400 to-emerald-500 text-white font-bold text-lg shadow-lg flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ __('onboarding.status.'.$profile->status) }}</span>
                            </div>
                        @elseif($profile->status === 'pending')
                            <div class="px-6 py-3 rounded-2xl bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold text-lg shadow-lg flex items-center gap-2">
                                <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span>{{ __('onboarding.status.'.$profile->status) }}</span>
                            </div>
                        @else
                            <div class="px-6 py-3 rounded-2xl bg-gradient-to-r from-red-400 to-pink-500 text-white font-bold text-lg shadow-lg flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ __('onboarding.status.'.$profile->status) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Services Count -->
                <div class="relative overflow-hidden bg-gradient-to-br from-accent-DEFAULT to-accent-amber rounded-3xl p-8 shadow-2xl transform transition-all hover:scale-105">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2">Services Offered</div>
                        <div class="text-5xl font-extrabold text-white mb-2">{{ $profile->services->count() }}</div>
                        <div class="text-white/90 text-base font-medium">Active services</div>
                    </div>
                </div>

                <!-- Completed Jobs -->
                <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-accent-copper rounded-3xl p-8 shadow-2xl transform transition-all hover:scale-105">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2">Completed Jobs</div>
                        <div class="text-5xl font-extrabold text-white mb-2">{{ $profile->completed_jobs }}</div>
                        <div class="text-white/90 text-base font-medium">Successful deliveries</div>
                    </div>
                </div>

                <!-- Rating -->
                <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-yellow-600 rounded-3xl p-8 shadow-2xl transform transition-all hover:scale-105">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2">Average Rating</div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="text-5xl font-extrabold text-white">{{ $profile->avg_rating ?? 'N/A' }}</div>
                            @if($profile->avg_rating)
                                <svg class="w-10 h-10 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="text-white/90 text-base font-medium">Out of 5.00</div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Profile Info & Bio -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Profile Card -->
                    <div class="bg-white rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-accent-copper p-8">
                            <h2 class="text-3xl font-extrabold text-white mb-2 flex items-center gap-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Information
                            </h2>
                            <p class="text-white/90 text-lg">Your public profile details</p>
                        </div>
                        <div class="p-8">
                            <div class="space-y-6">
                                <div>
                                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Display Name</div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $profile->display_name }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Location</div>
                                    <div class="text-xl font-semibold text-gray-700 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $profile->city }}
                                    </div>
                                </div>
                                @if($profile->bio)
                                    <div>
                                        <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">About</div>
                                        <div class="text-base text-gray-700 leading-relaxed">{{ $profile->bio }}</div>
                                    </div>
                                @endif
                                @if($profile->website)
                                    <div>
                                        <div class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Website</div>
                                        <a href="{{ $profile->website }}" target="_blank" class="text-lg text-accent-DEFAULT hover:text-accent-amber hover:underline flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            {{ $profile->website }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Services Card -->
                    <div class="bg-white rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 via-teal-500 to-cyan-600 p-8">
                            <h2 class="text-3xl font-extrabold text-white mb-2 flex items-center gap-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Your Services
                            </h2>
                            <p class="text-white/90 text-lg">Services you offer with pricing</p>
                        </div>
                        <div class="p-8">
                            @if($profile->services->count() > 0)
                                <div class="grid gap-4">
                                    @foreach($profile->services as $svc)
                                        <div class="flex items-center justify-between p-5 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-accent-amber/30 hover:border-accent-amber transition-all hover:shadow-lg">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white text-xl font-bold shadow-lg">
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
                                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No services added yet</p>
                                </div>
                            @endif
                            <div class="mt-8">
                                <a href="{{ route('provider.services') }}" class="block w-full py-4 px-6 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white text-center font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit Services
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Photos & Quick Actions -->
                <div class="space-y-8">
                    <!-- Photos Gallery -->
                    <div class="bg-white rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-accent-copper via-orange-600 to-amber-600 p-6">
                            <h2 class="text-2xl font-extrabold text-white mb-1 flex items-center gap-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Gallery
                            </h2>
                            <p class="text-white/90 text-sm">Portfolio photos</p>
                        </div>
                        <div class="p-6">
                            @if($profile->photos_json && count($profile->photos_json) > 0)
                                <div class="grid grid-cols-2 gap-3 mb-6">
                                    @foreach(array_slice($profile->photos_json, 0, 6) as $photo)
                                        <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105">
                                            <img src="{{ Storage::url($photo) }}" class="w-full h-32 object-cover" alt="Portfolio">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($profile->photos_json) > 6)
                                    <div class="text-center text-sm font-bold text-gray-600 mb-6">
                                        +{{ count($profile->photos_json) - 6 }} more photos
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">No photos yet</p>
                                </div>
                            @endif
                            <a href="{{ route('provider.photos') }}" class="block w-full py-3 px-6 bg-gradient-to-r from-accent-copper to-orange-600 hover:from-orange-700 hover:to-amber-700 text-white text-center font-bold text-base rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Manage Photos
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-orange-500 p-6">
                            <h2 class="text-2xl font-extrabold text-white mb-1 flex items-center gap-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Quick Actions
                            </h2>
                            <p class="text-white/90 text-sm">Manage your profile</p>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('provider.start') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-accent-amber/30 hover:border-accent-amber hover:shadow-lg transition-all group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-base font-bold text-gray-900">Edit Profile</div>
                                    <div class="text-sm text-gray-600">Update your information</div>
                                </div>
                            </a>

                            <a href="{{ route('providers.show', ['username' => $profile->user->name]) }}" class="flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 hover:border-green-400 hover:shadow-lg transition-all group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-base font-bold text-gray-900">View Public Profile</div>
                                    <div class="text-sm text-gray-600">See how others see you</div>
                                </div>
                            </a>

                            <a href="{{ route('home') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 hover:border-blue-400 hover:shadow-lg transition-all group">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-base font-bold text-gray-900">Back to Home</div>
                                    <div class="text-sm text-gray-600">Browse the platform</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-2xl p-12 text-center">
                <svg class="w-32 h-32 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-3xl font-bold text-gray-700 mb-4">No Profile Found</h2>
                <p class="text-xl text-gray-600 mb-8">You haven't created a provider profile yet.</p>
                <a href="{{ route('provider.start') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold text-xl rounded-2xl shadow-2xl hover:shadow-accent-amber/50 transition-all transform hover:scale-105">
                    Create Your Profile Now
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
