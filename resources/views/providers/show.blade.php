@extends('layouts.app')
@section('content')
@section('title', $profile->display_name . ' - ' . config('app.name'))
@section('description', Str::limit($profile->bio, 150) ?: __('seo.providers_description'))
@section('og_title', $profile->display_name)
@section('og_description', Str::limit($profile->bio, 150) ?: __('seo.providers_description'))
@if($profile->photos_json && count($profile->photos_json) > 0)
@section('og_image', Storage::url($profile->photos_json[0]))
    @endif
    <div class="max-w-5xl mx-auto py-8 px-4 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold mb-1">{{ $profile->display_name }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $profile->city }}</p>
                <div class="flex gap-2 mt-2 text-xs">
                    @if($profile->badge_level)<span
                    class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded">{{ $profile->badge_level }}</span>@endif
                    @if($profile->avg_rating)<span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded">★
                    {{ $profile->avg_rating }}</span>@endif
                    <span class="px-2 py-0.5 bg-gray-200 dark:bg-gray-700 rounded">{{ $profile->completed_jobs }}
                        jobs</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('requests.create') }}"
                    class="self-start px-4 py-2 bg-indigo-600 text-white rounded text-sm">{{ __('providers.show.request_cta') }}</a>
                @auth
                    @if(auth()->user()->hasRole('client'))
                        <a href="{{ route('requests.mine') }}"
                            class="self-start px-4 py-2 bg-gray-600 text-white rounded text-sm">{{ __('requests.mine_link') ?: 'My Requests' }}</a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <x-card>
                    <h2 class="font-semibold mb-2">About</h2>
                    <p class="text-sm mb-3">{{ $profile->bio }}</p>
                    @if($profile->skills_json)
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach($profile->skills_json as $sk)
                                <span class="px-2 py-0.5 text-xs bg-gray-200 dark:bg-gray-700 rounded">{{ $sk }}</span>
                            @endforeach
                        </div>
                    @endif
                    @if($profile->cities_json)
                        <h3 class="text-sm font-medium mt-4 mb-1">Coverage</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ implode(', ', $profile->cities_json) }}</p>
                    @endif
                </x-card>

                <x-card>
                    <h2 class="font-semibold mb-2">Services</h2>
                    <ul class="text-sm space-y-1">
                        @foreach($profile->services as $svc)
                            <li class="flex justify-between"><span>{{ $svc->name }}</span><span
                                    class="text-gray-500 text-xs">@if($svc->pivot->price_min || $svc->pivot->price_max)
                                    {{ $svc->pivot->price_min }} - {{ $svc->pivot->price_max }} @endif</span></li>
                        @endforeach
                    </ul>
                </x-card>

                <x-card>
                    <h2 class="font-semibold mb-2">Gallery</h2>
                    @if($profile->photos_json)
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($profile->photos_json as $p)
                                <img src="{{ Storage::url($p) }}" class="rounded object-cover aspect-square" />
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No photos yet.</p>
                    @endif
                </x-card>
            </div>
            <div class="space-y-6">
                <x-card>
                    <h2 class="font-semibold mb-2">Stats</h2>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Rating: {{ $profile->avg_rating ?? '—' }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Jobs: {{ $profile->completed_jobs }}</p>
                </x-card>
            </div>
        </div>
    </div>
@endsection