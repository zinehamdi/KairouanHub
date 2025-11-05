@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 space-y-8">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-semibold mb-1">{{ __('requests.show.title') }} #{{ $job->id }}</h1>
            <p class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</p>
        </div>
        <span class="px-3 py-1 text-xs rounded bg-indigo-100 text-indigo-700">{{ __('requests.statuses.'.$job->status) }}</span>
    </div>
    <x-card class="p-6 space-y-4">
        <div class="text-sm"><strong>{{ __('requests.show.summary') }}:</strong> {{ $job->category?->name }} @if($job->service) → {{ $job->service?->name }} @endif</div>
        <div class="text-sm"><strong>{{ __('requests.create.city') }}:</strong> {{ $job->city }}</div>
        <div class="text-sm whitespace-pre-wrap"><strong>{{ __('requests.create.details') }}:</strong> {{ $job->details }}</div>
        @if($job->photos_json)
            <div class="grid grid-cols-4 gap-2">
                @foreach($job->photos_json as $p)
                    <img src="{{ Storage::url($p) }}" class="rounded object-cover aspect-square" />
                @endforeach
            </div>
        @endif
    </x-card>

    @if($isOwner)
        <x-card class="p-6">
            <h2 class="font-semibold mb-4">{{ __('requests.show.offers_title') }}</h2>
            @if($job->offers->count())
                <div class="space-y-3">
                @foreach($job->offers as $offer)
                    <div class="border rounded p-3 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div class="text-sm">
                            <p class="font-medium">{{ $offer->provider?->display_name }}</p>
                            <p class="text-xs text-gray-500">{{ __('offers.statuses.'.$offer->status) }}</p>
                            @if($offer->note)<p class="text-xs mt-1">{{ $offer->note }}</p>@endif
                        </div>
                        <div class="flex items-center gap-4 text-xs">
                            @if($offer->price) <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-700 rounded">{{ $offer->price }} TND</span>@endif
                            @if($offer->eta_days) <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-700 rounded">{{ $offer->eta_days }} d</span>@endif
                            @if($job->status === 'open' && $offer->status === 'pending')
                                <form method="POST" action="{{ route('offers.accept',$offer->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded text-xs">{{ __('requests.show.accept') }}</button>
                                </form>
                            @else
                                @if($offer->status === 'accepted')<span class="text-green-600 font-medium">{{ __('requests.show.accepted') }}</span>@endif
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">{{ __('requests.show.no_offers_yet') }}</p>
            @endif
        </x-card>
    @endif

    @auth
        @if(!$isOwner && auth()->user()->providerProfile)
            @php($myOffer = $job->offers->firstWhere('provider_id', auth()->user()->providerProfile->id))
            @include('requests._offer_form', ['job' => $job, 'offer' => $myOffer])
        @endif
    @endauth
</div>
@endsection
