@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-cover bg-center bg-fixed py-12" style="background-image: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(226, 142, 12, 0.20), rgba(160, 137, 112, 0.25)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-flash />
        
        <!-- Wizard Progress Header -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <!-- Step 1 - Active -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-accent-DEFAULT via-accent-amber to-accent-copper text-white font-bold shadow-gold animate-pulse">
                        1
                    </div>
                    <span class="ml-2 text-sm font-bold bg-gradient-to-r from-accent-DEFAULT to-accent-amber bg-clip-text text-transparent">Basic Info</span>
                </div>
                <div class="flex-1 h-1.5 bg-gradient-to-r from-gray-300 to-gray-200 max-w-[100px] rounded-full"></div>
                
                                
                <!-- Step 2 - Inactive -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 text-white font-bold shadow-lg">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Services</span>
                </div>
                <div class="flex-1 h-1.5 bg-gradient-to-r from-gray-300 to-gray-200 max-w-[100px] rounded-full"></div>
                
                <!-- Step 3 - Inactive -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 text-white font-bold shadow-lg">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-600">Photos</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border-4 border-transparent bg-gradient-to-br from-white via-kairouan-beige/30 to-accent-copper/20 overflow-hidden hover:shadow-gold transition-all duration-500">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-accent-copper px-8 py-8 relative overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.1) 10px, rgba(255,255,255,0.1) 20px);"></div>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg relative z-10">{{ __('onboarding.step1.title') }}</h1>
                <p class="text-white/95 text-lg relative z-10">Tell us about yourself and your business</p>
            </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl border-2 border-accent-DEFAULT/30 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-accent-DEFAULT to-accent-amber px-8 py-6">
                <h1 class="text-3xl font-bold text-white mb-2">{{ __('onboarding.step1.title') }}</h1>
                <p class="text-white/90">Let's get started with your basic information</p>
                @if(!$auto)
                    <div class="mt-3 bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 border border-white/30">
                        <p class="text-sm text-white">{{ __('onboarding.status.pending') }} – {{ __('messages.review_pending') }}</p>
                    </div>
                @endif
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('provider.store') }}" class="p-8">
                @csrf
                
                <div class="space-y-6">
                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-base font-bold text-gray-900 mb-2">
                            {{ __('onboarding.fields.display_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="display_name" name="display_name" type="text" required
                            class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                            placeholder="Your business or professional name">
                        <x-input-error :messages="$errors->get('display_name')" class="mt-1" />
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-base font-bold text-gray-900 mb-2">
                            {{ __('onboarding.fields.city') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="city" name="city" type="text" required
                            class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                            placeholder="Kairouan">
                        <x-input-error :messages="$errors->get('city')" class="mt-1" />
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-base font-bold text-gray-900 mb-2">
                            {{ __('onboarding.fields.bio') }}
                        </label>
                        <textarea id="bio" name="bio" rows="4"
                            class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                            placeholder="Tell us about your services and experience..."></textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-1" />
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-base font-bold text-gray-900 mb-2">
                            {{ __('onboarding.fields.website') }}
                        </label>
                        <input id="website" name="website" type="url"
                            class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                            placeholder="https://example.com">
                        <x-input-error :messages="$errors->get('website')" class="mt-1" />
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="block text-base font-bold text-gray-900 mb-2">
                            {{ __('onboarding.fields.skills') }}
                        </label>
                        <input id="skills" name="skills" type="text"
                            class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                            placeholder="e.g. plumbing, design, electrical">
                        <p class="mt-1 text-sm text-gray-600">Separate skills with commas</p>
                    </div>

                    <!-- Cities Served -->
                    <div>
                        <label for="cities" class="block text-base font-bold text-gray-900 mb-2">
                            {{ __('onboarding.fields.cities') }}
                        </label>
                        <input id="cities" name="cities" type="text"
                            class="w-full px-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                            placeholder="Kairouan, Tunis, Sousse">
                        <p class="mt-1 text-sm text-gray-600">Separate cities with commas</p>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <label class="block text-base font-bold text-gray-900 mb-3">
                            {{ __('onboarding.fields.social') }}
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['facebook','instagram','tiktok','linkedin'] as $s)
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        </svg>
                                    </div>
                                    <input name="social[{{$s}}]" type="url"
                                        class="w-full pl-10 pr-4 py-3 text-base rounded-xl border-2 border-gray-200 focus:border-accent-DEFAULT focus:ring-4 focus:ring-accent-DEFAULT/20 transition-all duration-300"
                                        placeholder="{{ ucfirst($s) }} URL">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('home') }}" class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium transition-colors duration-300">
                        ← Cancel
                    </a>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-gold hover:scale-105 transition-all duration-300">
                        {{ __('onboarding.buttons.next') }} →
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Need help? Contact us at <a href="mailto:support@kairouanhub.com" class="text-accent-DEFAULT font-medium hover:text-accent-amber">support@kairouanhub.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
