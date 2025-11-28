@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-blue-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ __('Create Service Request') }}</h1>
            <p class="text-lg text-gray-600">{{ __('Tell us what you need and receive proposals from qualified providers') }}</p>
        </div>

        @guest
            <!-- Login Prompt -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Login Required') }}</h3>
                <p class="text-gray-600 mb-8">{{ __('Please login or register to create a service request') }}</p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all">
                        {{ __('Register') }}
                    </a>
                </div>
            </div>
        @else
            <!-- Request Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8" 
                 x-data="{
                     cat:'', 
                     services: {{ json_encode(App\Models\Service::select('id','name','category_id')->orderBy('name')->get()) }},
                     photoPreview: []
                 }">
                
                <form method="POST" action="{{ route('requests.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Category Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('Service Category') }} <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" x-model="cat" required 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-base">
                            <option value="">{{ __('Select a category') }}</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('Specific Service') }} <span class="text-gray-400 text-xs">({{ __('Optional') }})</span>
                        </label>
                        <select name="service_id" 
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-base">
                            <option value="">{{ __('General request for this category') }}</option>
                            <template x-for="s in services.filter(v=>!cat || v.category_id==cat)" :key="s.id">
                                <option :value="s.id" x-text="s.name"></option>
                            </template>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">{{ __('Select a specific service or leave general for the category') }}</p>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('City / Location') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" required maxlength="120" value="{{ old('city') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-base"
                               placeholder="{{ __('e.g. Kairouan, Sousse, Tunis...') }}">
                        @error('city')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Details -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('Request Details') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea name="details" required maxlength="2000" rows="6"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-base"
                                  placeholder="{{ __('Describe what you need in detail: scope, timeline, budget expectations, special requirements...') }}">{{ old('details') }}</textarea>
                        <p class="mt-2 text-sm text-gray-500">{{ __('Be specific to receive better proposals') }}</p>
                        @error('details')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Photos Upload -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __('Photos') }} <span class="text-gray-400 text-xs">({{ __('Optional') }})</span>
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-600 font-semibold">{{ __('Click to upload photos') }}</p>
                                    <p class="text-xs text-gray-500">{{ __('PNG, JPG, WEBP (MAX. 10MB per file)') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Upload up to 4 photos') }}</p>
                                </div>
                                <input type="file" name="photos[]" multiple accept="image/*" class="hidden" />
                            </label>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 inline-block mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Photos help providers better understand your needs') }}
                        </p>
                        @error('photos')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            <span class="text-red-500">*</span> {{ __('Required fields') }}
                        </p>
                        <button type="submit" 
                                class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <svg class="w-6 h-6 inline-block mr-2 rtl:ml-2 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            {{ __('Submit Request') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-blue-900 mb-3 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('What happens next?') }}
                </h3>
                <ul class="space-y-2 text-blue-800">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ __('Your request will be visible to qualified providers in your area') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ __('You\'ll receive proposals with pricing and timelines') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ __('Review proposals and choose the best provider for your needs') }}</span>
                    </li>
                </ul>
            </div>
        @endguest
    </div>
</div>
@endsection
