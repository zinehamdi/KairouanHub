@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('requests.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                <svg class="w-5 h-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Back to Requests') }}
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <h1 class="text-3xl font-bold text-gray-900">{{ __('Service Request') }} #{{ $job->id }}</h1>
                        <span class="px-4 py-2 text-sm font-bold rounded-full 
                            @if($job->status === 'open') bg-green-100 text-green-700
                            @elseif($job->status === 'assigned') bg-blue-100 text-blue-700
                            @elseif($job->status === 'completed') bg-gray-100 text-gray-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="font-medium">{{ $job->city }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category & Service -->
            <div class="flex flex-wrap gap-3 mb-6">
                <span class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg">
                    {{ $job->category?->name ?? __('General') }}
                </span>
                @if($job->service)
                    <span class="px-4 py-2 bg-green-100 text-green-700 font-semibold rounded-lg">
                        {{ $job->service?->name }}
                    </span>
                @endif
            </div>

            <!-- Details -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-3">{{ __('Request Details') }}</h3>
                <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $job->details }}</p>
            </div>

            <!-- Photos Gallery -->
            @if($job->photos_json && count($job->photos_json) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Photos') }} ({{ count($job->photos_json) }})</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($job->photos_json as $photo)
                            <div class="group relative aspect-square overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                                <img src="{{ asset('storage/' . $photo) }}" 
                                     alt="Request photo" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Offers Section (for request owner) -->
        @if($isOwner)
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('Proposals Received') }}</h2>
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg">
                        {{ $job->offers->count() }} {{ __('Proposals') }}
                    </span>
                </div>

                @if($job->offers->count() > 0)
                    <div class="space-y-4">
                        @foreach($job->offers as $offer)
                            <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-blue-300 transition-all">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-bold text-gray-900">{{ $offer->provider?->display_name }}</h4>
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                                @if($offer->status === 'pending') bg-yellow-100 text-yellow-700
                                                @elseif($offer->status === 'accepted') bg-green-100 text-green-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ ucfirst($offer->status) }}
                                            </span>
                                        </div>
                                        @if($offer->note)
                                            <p class="text-gray-600 mb-3">{{ $offer->note }}</p>
                                        @endif
                                        <div class="flex flex-wrap gap-3">
                                            @if($offer->price)
                                                <div class="flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-lg font-semibold">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $offer->price }} TND
                                                </div>
                                            @endif
                                            @if($offer->eta_days)
                                                <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg font-semibold">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ $offer->eta_days }} {{ __('days') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($job->status === 'open' && $offer->status === 'pending')
                                        <form method="POST" action="{{ route('offers.accept', $offer->id) }}">
                                            @csrf
                                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all">
                                                {{ __('Accept Proposal') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">{{ __('No proposals received yet') }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Submit Proposal Form (for providers) -->
        @auth
            @if(!$isOwner && auth()->user()->providerProfile)
                @php($myOffer = $job->offers->firstWhere('provider_id', auth()->user()->providerProfile->id))
                
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        @if($myOffer)
                            {{ __('Your Proposal') }}
                        @else
                            {{ __('Submit Your Proposal') }}
                        @endif
                    </h2>
                    
                    @if($myOffer)
                        <div class="border-2 border-blue-200 rounded-xl p-6 bg-blue-50 mb-6">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-lg font-bold text-blue-900">{{ __('Proposal Submitted') }}</span>
                            </div>
                            @if($myOffer->note)
                                <p class="text-gray-700 mb-3">{{ $myOffer->note }}</p>
                            @endif
                            <div class="flex flex-wrap gap-3">
                                @if($myOffer->price)
                                    <span class="px-4 py-2 bg-white border-2 border-blue-300 text-blue-700 font-bold rounded-lg">
                                        {{ $myOffer->price }} TND
                                    </span>
                                @endif
                                @if($myOffer->eta_days)
                                    <span class="px-4 py-2 bg-white border-2 border-blue-300 text-blue-700 font-bold rounded-lg">
                                        {{ $myOffer->eta_days }} {{ __('days') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('offers.store', $job->id) }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Your Proposal Message') }}</label>
                                <textarea name="note" rows="4" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                    placeholder="{{ __('Describe your approach, experience, and why you\'re the right fit...') }}"></textarea>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Proposed Price (TND)') }}</label>
                                    <input type="number" name="price" step="0.01" min="0"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Estimated Days') }}</label>
                                    <input type="number" name="eta_days" min="1"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                        placeholder="1">
                                </div>
                            </div>

                            <button type="submit" class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-xl transition-all">
                                {{ __('Submit Proposal') }}
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
