@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-amber-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                {{ __('Browse Service Requests') }}
            </h1>
            <p class="text-lg text-gray-600">
                {{ __('Find new opportunities and submit your proposals') }}
            </p>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('requests.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('City') }}</label>
                    <input type="text" name="city" value="{{ request('city') }}" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                           placeholder="{{ __('Filter by city') }}">
                </div>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg transition-all">
                    <svg class="w-5 h-5 inline-block mr-2 rtl:mr-0 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    {{ __('Filter') }}
                </button>
            </form>
        </div>

        <!-- Requests Grid -->
        @if($requests->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($requests as $request)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100 hover:border-blue-300">
                        <!-- Photo Preview -->
                        @if($request->photos_json && count($request->photos_json) > 0)
                            <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 relative overflow-hidden">
                                <img src="{{ asset('storage/' . $request->photos_json[0]) }}" 
                                     alt="Request photo" 
                                     class="w-full h-full object-cover">
                                @if(count($request->photos_json) > 1)
                                    <span class="absolute top-3 right-3 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        +{{ count($request->photos_json) - 1 }} {{ __('photos') }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Category Badge -->
                            <div class="mb-3">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-sm font-bold rounded-full">
                                    {{ $request->category->name ?? __('General') }}
                                </span>
                                @if($request->service)
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full ml-2 rtl:ml-0 rtl:mr-2">
                                        {{ $request->service->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Details -->
                            <p class="text-gray-700 mb-4 line-clamp-3">
                                {{ $request->details }}
                            </p>

                            <!-- Location & Date -->
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="font-medium">{{ $request->city }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $request->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('requests.show', $request->id) }}" 
                               class="block w-full text-center px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all">
                                {{ __('View Details & Submit Proposal') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $requests->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ __('No Requests Available') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('Check back later for new service requests in your area.') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
