@extends('layouts.app')

@section('title', $provider->display_name . ' - ' . ($provider->category->name ?? 'Provider'))

@section('content')
    <div class="min-h-screen bg-gray-50 pb-12">
        {{-- Hero Section --}}
        <div class="bg-white shadow-sm border-b border-gray-100">
            <div class="container mx-auto px-4 py-8 md:py-12">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8">
                    {{-- Avatar --}}
                    <div class="relative group">
                        <div
                            class="w-32 h-32 md:w-40 md:h-40 rounded-full p-1 bg-gradient-to-br from-accent-DEFAULT to-accent-amber shadow-xl">
                            <img src="{{ $provider->avatar_url }}" alt="{{ $provider->display_name }}"
                                class="w-full h-full rounded-full object-cover border-4 border-white">
                        </div>
                        @if($provider->badge_level)
                            <div class="absolute bottom-2 right-2 bg-white rounded-full p-1.5 shadow-md"
                                title="Verified Provider">
                                <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-2 mb-2 justify-center md:justify-start">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $provider->display_name }}</h1>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-accent-DEFAULT/10 text-accent-DEFAULT">
                                {{ $provider->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-center md:justify-start gap-4 text-gray-600 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="font-bold text-gray-900">{{ number_format($provider->avg_rating, 1) }}</span>
                                <span class="text-sm">({{ $provider->completed_jobs }} jobs)</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $provider->city }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                            <a href="{{ route('requests.create', ['provider_id' => $provider->id]) }}"
                                class="px-8 py-3 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                Request Quote
                            </a>
                            <button
                                class="px-6 py-3 bg-white border-2 border-gray-200 hover:border-accent-DEFAULT text-gray-700 font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Share Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- About --}}
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About</h2>
                        <div class="prose prose-orange max-w-none text-gray-600">
                            <p>{{ $provider->bio ?? 'No description available.' }}</p>
                        </div>
                    </div>

                    {{-- Services --}}
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Services Offered</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($provider->services as $service)
                                <div
                                    class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-accent-DEFAULT/30 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-bold text-gray-900">
                                            {{ app()->getLocale() === 'ar' ? ($service->name_ar ?? $service->name) : $service->name }}
                                        </h3>
                                        <span
                                            class="text-xs font-medium px-2 py-1 bg-white rounded-md text-gray-500 border border-gray-200">
                                            {{ $service->category->name ?? 'General' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($service->summary, 80) }}</p>
                                    @if($service->pivot->price_min || $service->pivot->price_max)
                                        <div class="text-accent-DEFAULT font-bold text-sm">
                                            @if($service->pivot->price_min && $service->pivot->price_max)
                                                {{ number_format($service->pivot->price_min) }} -
                                                {{ number_format($service->pivot->price_max) }} TND
                                            @elseif($service->pivot->price_min)
                                                From {{ number_format($service->pivot->price_min) }} TND
                                            @else
                                                Up to {{ number_format($service->pivot->price_max) }} TND
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-gray-400 text-sm italic">Price on request</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Gallery --}}
                    @if($provider->photos_json && count($provider->photos_json) > 0)
                        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-gray-100"
                            x-data="{ lightboxOpen: false, activeImage: '' }">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Portfolio Gallery</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($provider->photos_json as $photo)
                                    <div class="aspect-square rounded-xl overflow-hidden cursor-pointer group relative"
                                        @click="lightboxOpen = true; activeImage = '{{ asset('storage/' . $photo) }}'">
                                        <img src="{{ asset('storage/' . $photo) }}"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                            alt="Portfolio">
                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity transform scale-75 group-hover:scale-100"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Lightbox --}}
                            <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                                @keydown.escape.window="lightboxOpen = false">
                                <div class="relative max-w-5xl w-full max-h-full" @click.away="lightboxOpen = false">
                                    <button @click="lightboxOpen = false"
                                        class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <img :src="activeImage" class="w-full h-full object-contain rounded-lg shadow-2xl">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        {{-- Contact Card --}}
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Provider</h3>
                            <a href="{{ route('requests.create', ['provider_id' => $provider->id]) }}"
                                class="block w-full text-center py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber hover:from-accent-amber hover:to-accent-copper text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all mb-4">
                                Request a Quote
                            </a>
                            <p class="text-center text-sm text-gray-500 mb-6">Response time: Usually within 2 hours</p>

                            <div class="space-y-4 pt-6 border-t border-gray-100">
                                @if($provider->website)
                                    <a href="{{ $provider->website }}" target="_blank"
                                        class="flex items-center gap-3 text-gray-600 hover:text-accent-DEFAULT transition-colors">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-accent-DEFAULT">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                            </svg>
                                        </div>
                                        <span class="font-medium">Visit Website</span>
                                    </a>
                                @endif

                                <div class="flex items-center gap-3 text-gray-600">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-accent-DEFAULT">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">{{ $provider->city }}</span>
                                </div>

                                <div class="flex items-center gap-3 text-gray-600">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-accent-DEFAULT">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Member since {{ $provider->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection