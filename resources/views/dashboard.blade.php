@extends('layouts.app')
@section('content')
    @if($profile)
        {{-- PROVIDER PROFILE DASHBOARD --}}
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">

            @if(session('success'))
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- COVER IMAGE --}}
            <div class="h-64 bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-accent-copper relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute inset-0"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.05&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); opacity: 0.3;">
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- PROFILE HEADER CARD --}}
                <div class="relative -mt-32 mb-8">
                    <div class="bg-white rounded-3xl shadow-2xl p-8" x-data="{ uploadMode: false, tab: 'about' }">
                        <div class="flex flex-col lg:flex-row items-start gap-8">
                            {{-- Avatar with Upload --}}
                            <div class="relative group flex-shrink-0">
                                <img src="{{ $profile->avatar_url }}" alt="{{ $profile->display_name }}"
                                    class="w-48 h-48 rounded-2xl object-cover border-8 border-white shadow-2xl ring-4 ring-accent-DEFAULT/20 group-hover:ring-accent-DEFAULT/40 transition-all">
                                <button @click="uploadMode = !uploadMode"
                                    class="absolute bottom-4 right-4 bg-accent-DEFAULT hover:bg-accent-amber text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>

                                {{-- Quick Upload Modal --}}
                                <div x-show="uploadMode" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100" @click.away="uploadMode = false"
                                    class="absolute top-full left-0 mt-4 bg-white rounded-2xl shadow-2xl p-6 w-96 z-50 border border-gray-100">
                                    <form action="{{ route('provider.avatar.update') }}" method="POST"
                                        enctype="multipart/form-data" x-data="{ fileName: '' }">
                                        @csrf
                                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-accent-DEFAULT" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Upload New Avatar
                                        </h3>
                                        <input type="file" name="avatar" accept="image/*"
                                            @change="fileName = $event.target.files[0]?.name || ''"
                                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 
                                                              file:rounded-xl file:border-0 file:text-sm file:font-semibold
                                                              file:bg-gradient-to-r file:from-accent-DEFAULT file:to-accent-amber 
                                                              file:text-white hover:file:from-accent-amber hover:file:to-accent-copper
                                                              file:cursor-pointer file:shadow-md hover:file:shadow-lg file:transition-all
                                                              border-2 border-dashed border-gray-300 rounded-xl p-4 mb-3
                                                              hover:border-accent-DEFAULT focus:border-accent-DEFAULT transition-all">
                                        <p class="text-xs text-gray-500 mb-4 flex items-start gap-2" x-show="!fileName">
                                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>JPG, PNG or WEBP. Max 2MB. Automatically converts to WebP.</span>
                                        </p>
                                        <p class="text-sm text-accent-DEFAULT font-semibold mb-4 flex items-center gap-2"
                                            x-show="fileName">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span x-text="'Selected: ' + fileName"></span>
                                        </p>
                                        <div class="flex gap-3">
                                            <button type="submit"
                                                class="flex-1 px-6 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                                Upload Photo
                                            </button>
                                            <button type="button" @click="uploadMode = false"
                                                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Profile Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $profile->display_name }}</h1>
                                        <div class="flex flex-wrap items-center gap-4 text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-accent-DEFAULT" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="font-semibold">{{ $profile->city }}</span>
                                            </div>
                                            @if($profile->avg_rating)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <span class="font-semibold">{{ number_format($profile->avg_rating, 1) }}
                                                        Rating</span>
                                                </div>
                                            @endif
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="font-semibold">{{ $profile->completed_jobs }} Jobs Completed</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Stats Grid --}}
                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-4 text-white">
                                        <div class="text-3xl font-extrabold mb-1">{{ $profile->services->count() }}</div>
                                        <div class="text-sm opacity-90 font-medium">Services</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-4 text-white">
                                        <div class="text-3xl font-extrabold mb-1">{{ $profile->completed_jobs }}</div>
                                        <div class="text-sm opacity-90 font-medium">Completed</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-4 text-white">
                                        <div class="text-3xl font-extrabold mb-1">
                                            {{ $profile->avg_rating ? number_format($profile->avg_rating, 1) : 'N/A' }}</div>
                                        <div class="text-sm opacity-90 font-medium">Rating</div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('profile.edit') }}"
                                        class="px-6 py-3 bg-accent-DEFAULT hover:bg-accent-amber text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Profile
                                    </a>
                                    <a href="{{ route('provider.services') }}"
                                        class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl shadow-md hover:shadow-lg transition-all border-2 border-gray-200 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Services
                                    </a>
                                    <button @click="tab = 'gallery'"
                                        class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl shadow-md hover:shadow-lg transition-all border-2 border-gray-200 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Gallery
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Tabs Navigation --}}
                        <div class="flex gap-2 mt-8 pt-8 border-t border-gray-200">
                            <button @click="tab = 'about'"
                                :class="tab === 'about' ? 'bg-accent-DEFAULT text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-6 py-3 rounded-xl font-bold transition-all">
                                About
                            </button>
                            <button @click="tab = 'services'"
                                :class="tab === 'services' ? 'bg-accent-DEFAULT text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-6 py-3 rounded-xl font-bold transition-all">
                                Services ({{ $profile->services->count() }})
                            </button>
                            <button @click="tab = 'gallery'"
                                :class="tab === 'gallery' ? 'bg-accent-DEFAULT text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="px-6 py-3 rounded-xl font-bold transition-all">
                                Gallery ({{ $profile->photos_json ? count($profile->photos_json) : 0 }})
                            </button>
                        </div>

                        {{-- Tab Content --}}
                        <div class="mt-6">
                            {{-- About Tab --}}
                            <div x-show="tab === 'about'" x-transition>
                                @if($profile->bio)
                                    <div class="bg-gray-50 rounded-2xl p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">About Me</h3>
                                        <p class="text-gray-700 leading-relaxed">{{ $profile->bio }}</p>
                                    </div>
                                @else
                                    <div class="text-center py-12">
                                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <p class="text-gray-500 mb-4">No bio added yet</p>
                                        <a href="{{ route('profile.edit') }}"
                                            class="inline-block px-6 py-3 bg-accent-DEFAULT hover:bg-accent-amber text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                            Add Bio
                                        </a>
                                    </div>
                                @endif

                                @if($profile->website)
                                    <div class="mt-4 bg-blue-50 rounded-2xl p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">Website</h3>
                                        <a href="{{ $profile->website }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            {{ $profile->website }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Services Tab --}}
                            <div x-show="tab === 'services'" x-transition
                                x-data="{ showAddModal: false, editingService: null, editPriceMin: '', editPriceMax: '' }">
                                {{-- Add Service Button --}}
                                <div class="mb-6 flex justify-between items-center">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ __('dashboard.services.title') }}</h3>
                                    <button @click="showAddModal = true"
                                        class="px-6 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ __('dashboard.modals.add_btn') }}
                                    </button>
                                </div>

                                @if($profile->services->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($profile->services as $service)
                                            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 shadow-md hover:shadow-xl transition-all border border-gray-100"
                                                x-data="{ showActions: false }">
                                                <div class="flex items-start justify-between mb-3">
                                                    <div class="flex-1">
                                                        <h3 class="text-xl font-bold text-gray-900">
                                                            {{ app()->getLocale() === 'ar' ? ($service->name_ar ?? $service->name) : $service->name }}
                                                        </h3>
                                                        @if($service->pivot->price_min || $service->pivot->price_max)
                                                            <p class="text-accent-DEFAULT font-semibold text-sm mt-1">
                                                                @if($service->pivot->price_min && $service->pivot->price_max)
                                                                    {{ number_format($service->pivot->price_min) }} -
                                                                    {{ number_format($service->pivot->price_max) }} TND
                                                                @elseif($service->pivot->price_min)
                                                                    {{ __('dashboard.modals.min_price') }} {{ number_format($service->pivot->price_min) }}
                                                                @else
                                                                    {{ __('dashboard.modals.max_price') }} {{ number_format($service->pivot->price_max) }}
                                                                @endif
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="relative">
                                                        <button @click="showActions = !showActions"
                                                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                            </svg>
                                                        </button>

                                                        {{-- Actions Dropdown --}}
                                                        <div x-show="showActions" @click.away="showActions = false" x-transition
                                                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-10">
                                                            <button
                                                                @click="editingService = {{ $service->id }}; editPriceMin = '{{ $service->pivot->price_min }}'; editPriceMax = '{{ $service->pivot->price_max }}'; showActions = false"
                                                                class="w-full px-4 py-2 text-left hover:bg-gray-50 flex items-center gap-2 text-gray-700">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                {{ __('dashboard.modals.edit_pricing_btn') }}
                                                            </button>
                                                            <form action="{{ route('provider.services.delete', $service) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('{{ __('dashboard.modals.remove_service_confirm') }}')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="w-full px-4 py-2 text-left hover:bg-red-50 flex items-center gap-2 text-red-600">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                        viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                    {{ __('dashboard.modals.remove_btn') }}
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($service->description)
                                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($service->description, 100) }}</p>
                                                @endif
                                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                                    <span class="text-gray-500 text-sm">{{ $service->category->name }}</span>
                                                    <a href="{{ route('services.show', $service) }}"
                                                        class="text-accent-DEFAULT hover:text-accent-amber font-semibold text-sm flex items-center gap-1">
                                                        {{ __('dashboard.modals.view_btn') }}
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </a>
                                                </div>

                                                {{-- Edit Price Modal --}}
                                                <div x-show="editingService === {{ $service->id }}" x-transition
                                                    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
                                                    @click.self="editingService = null">
                                                    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
                                                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                                                            {{ __('dashboard.modals.edit_pricing_title', ['service' => app()->getLocale() === 'ar' ? ($service->name_ar ?? $service->name) : $service->name]) }}
                                                        </h3>
                                                        <form action="{{ route('provider.services.update', $service) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="space-y-4">
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __('dashboard.modals.min_price') }}</label>
                                                                    <input type="number" name="price_min" x-model="editPriceMin"
                                                                        step="0.01" min="0"
                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all">
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __('dashboard.modals.max_price') }}</label>
                                                                    <input type="number" name="price_max" x-model="editPriceMax"
                                                                        step="0.01" min="0"
                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all">
                                                                </div>
                                                            </div>
                                                            <div class="flex gap-3 mt-6">
                                                                <button type="submit"
                                                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                                                    {{ __('dashboard.modals.update_pricing_btn') }}
                                                                </button>
                                                                <button type="button" @click="editingService = null"
                                                                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                                                                    {{ __('dashboard.modals.cancel_btn') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-16">
                                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium mb-4">{{ __('dashboard.modals.no_services_desc') }}</p>
                                        <button @click="showAddModal = true"
                                            class="inline-block px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                            {{ __('dashboard.modals.add_first_service') }}
                                        </button>
                                    </div>
                                @endif

                                {{-- Add Service Modal --}}
                                <div x-show="showAddModal" x-transition
                                    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
                                    @click.self="showAddModal = false">
                                    <div
                                        class="bg-white rounded-2xl p-8 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('dashboard.modals.add_service_title') }}</h3>
                                        <form action="{{ route('provider.services.add') }}" method="POST">
                                            @csrf
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('dashboard.modals.select_service') }}</label>
                                                    <select name="service_id" required
                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all">
                                                        <option value="">{{ __('dashboard.modals.choose_service') }}</option>
                                                        @php
                                                            $allServices = \App\Models\Service::with('category')->orderBy('name')->get();
                                                            $existingServiceIds = $profile->services->pluck('id')->toArray();
                                                        @endphp
                                                        @foreach($allServices as $availableService)
                                                            @if(!in_array($availableService->id, $existingServiceIds))
                                                                <option value="{{ $availableService->id }}">
                                                                    {{ app()->getLocale() === 'ar' ? ($availableService->name_ar ?? $availableService->name) : $availableService->name }}
                                                                    ({{ $availableService->category->name }})
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('dashboard.modals.min_price') }}</label>
                                                        <input type="number" name="price_min" step="0.01" min="0"
                                                            placeholder="{{ __('dashboard.modals.optional') }}"
                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('dashboard.modals.max_price') }}</label>
                                                        <input type="number" name="price_max" step="0.01" min="0"
                                                            placeholder="{{ __('dashboard.modals.optional') }}"
                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all">
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-500">{{ __('dashboard.modals.price_tip') }}</p>
                                            </div>
                                            <div class="flex gap-3 mt-6">
                                                <button type="submit"
                                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                                    {{ __('dashboard.modals.add_btn') }}
                                                </button>
                                                <button type="button" @click="showAddModal = false"
                                                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                                                    {{ __('dashboard.modals.cancel_btn') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Gallery Tab --}}
                            <div x-show="tab === 'gallery'" x-transition x-data="{ showUploadModal: false, lightboxPhoto: null }">
                                {{-- Upload Button --}}
                                <div class="mb-6 flex justify-between items-center">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ __('dashboard.gallery.title') }}</h3>
                                    <button @click="showUploadModal = true" 
                                            class="px-6 py-3 bg-gradient-to-r from-accent-copper to-orange-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ __('dashboard.modals.upload_btn') }}
                                    </button>
                                </div>

                                @if($profile->photos_json && count($profile->photos_json) > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach($profile->photos_json as $index => $photo)
                                            <div class="relative group overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-square">
                                                <img src="{{ asset('storage/' . $photo) }}"
                                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300"
                                                    alt="Gallery photo">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-2 p-4">
                                                    <button @click="lightboxPhoto = '{{ asset('storage/' . $photo) }}'"
                                                        class="px-4 py-2 bg-white text-gray-900 rounded-lg font-semibold text-sm transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                        </svg>
                                                        {{ __('dashboard.modals.view_btn') }}
                                                    </button>
                                                    <form action="{{ route('provider.gallery.delete', $index) }}" method="POST" 
                                                          onsubmit="return confirm('{{ __('dashboard.modals.delete_confirm') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            {{ __('dashboard.modals.delete_btn') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-6 text-center">
                                        <p class="text-gray-500 text-sm">
                                            {{ count($profile->photos_json) }} / {{ config('appsettings.providers.max_gallery', 6) }} photos uploaded
                                        </p>
                                    </div>
                                @else
                                    <div class="text-center py-16">
                                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium mb-4">{{ __('dashboard.modals.no_gallery_desc') }}</p>
                                        <p class="text-gray-400 mb-6">{{ __('dashboard.modals.gallery_tip') }}</p>
                                        <button @click="showUploadModal = true"
                                            class="inline-block px-8 py-4 bg-gradient-to-r from-accent-copper to-orange-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                            {{ __('dashboard.modals.upload_btn') }}
                                        </button>
                                    </div>
                                @endif

                                {{-- Upload Modal --}}
                                <div x-show="showUploadModal" 
                                     x-transition
                                     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
                                     @click.self="showUploadModal = false">
                                    <div class="bg-white rounded-2xl p-8 max-w-2xl w-full shadow-2xl">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('dashboard.modals.upload_title') }}</h3>
                                        <form action="{{ route('provider.gallery.upload') }}" method="POST" enctype="multipart/form-data"
                                              x-data="{ fileCount: 0 }">
                                            @csrf
                                            <div class="space-y-4">
                                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-accent-DEFAULT transition-all">
                                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                    </svg>
                                                    <label class="cursor-pointer">
                                                        <span class="text-accent-DEFAULT font-bold hover:text-accent-amber">{{ __('dashboard.modals.click_upload') }}</span>
                                                        <span class="text-gray-600"> {{ __('dashboard.modals.drag_drop') }}</span>
                                                        <input type="file" name="photos[]" accept="image/*" multiple 
                                                               @change="fileCount = $event.target.files.length"
                                                               class="hidden" max="6">
                                                    </label>
                                                    <p class="text-sm text-gray-500 mt-2">PNG, JPG, WEBP up to 10MB each</p>
                                                    <p class="text-sm text-gray-500">Maximum {{ config('appsettings.providers.max_gallery', 6) }} photos</p>
                                                </div>
                                                <p class="text-sm text-accent-DEFAULT font-semibold" x-show="fileCount > 0">
                                                    <span x-text="fileCount"></span> {{ __('dashboard.modals.file_selected', ['count' => '']) }}
                                                </p>
                                            </div>
                                            <div class="flex gap-3 mt-6">
                                                <button type="submit" 
                                                        class="flex-1 px-6 py-3 bg-gradient-to-r from-accent-copper to-orange-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                                                    {{ __('dashboard.modals.upload_btn') }}
                                                </button>
                                                <button type="button" @click="showUploadModal = false"
                                                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                                                    {{ __('dashboard.modals.cancel_btn') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- Lightbox --}}
                                <div x-show="lightboxPhoto" 
                                     x-transition
                                     class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 p-4"
                                     @click="lightboxPhoto = null">
                                    <button @click="lightboxPhoto = null" 
                                            class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <img :src="lightboxPhoto" alt="Gallery photo" class="max-w-full max-h-full object-contain">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- REGULAR USER DASHBOARD --}}
        <div class="min-h-screen bg-gradient-to-br from-kairouan-beige/30 via-amber-50 to-accent-copper/20 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-flash />

                <!-- Header -->
                <div class="mb-8">
                    <div class="bg-gradient-to-br from-accent-DEFAULT to-accent-amber p-1 rounded-2xl shadow-2xl">
                        <div class="bg-white p-8 rounded-2xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-3xl font-bold text-brand-dark mb-2">
                                        {{ __('dashboard.welcome', ['name' => auth()->user()->name]) }}
                                    </h3>
                                    <p class="text-brand-dark/70 text-lg">
                                        {{ __('dashboard.explore_services') }}
                                    </p>
                                </div>
                                <div class="hidden md:block">
                                    <div
                                        class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center text-white text-4xl font-bold shadow-xl">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <a href="{{ route('requests.create') }}"
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all group border-2 border-transparent hover:border-accent-DEFAULT">
                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-brand-dark mb-2">{{ __('dashboard.create_request') }}</h3>
                        <p class="text-brand-dark/60">{{ __('dashboard.request_subtitle') }}</p>
                    </a>

                    <a href="{{ route('services.index') }}"
                        class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all group border-2 border-transparent hover:border-accent-amber">
                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-accent-DEFAULT to-accent-amber flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-brand-dark mb-2">{{ __('dashboard.browse_services') }}</h3>
                        <p class="text-brand-dark/60">{{ __('dashboard.services_subtitle') }}</p>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="bg-gradient-to-br from-accent-DEFAULT to-accent-amber rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all group text-white">
                        <div
                            class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ __('dashboard.become_provider') }}</h3>
                        <p class="opacity-90">{{ __('dashboard.provider_subtitle') }}</p>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection