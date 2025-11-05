@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-cover bg-center bg-fixed py-12" style="background-image: linear-gradient(135deg, rgba(212, 175, 55, 0.25), rgba(226, 142, 12, 0.30), rgba(200, 145, 96, 0.35)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-flash />
        
        <!-- Wizard Progress Header with Vibrant Colors -->
        <div class="mb-10">
            <div class="flex items-center justify-center space-x-4">
                <!-- Step 1 - Active with Gold Animation -->
                <div class="flex items-center transform transition-all hover:scale-110">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-xl opacity-60 animate-pulse"></div>
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-accent-DEFAULT via-accent-amber to-accent-copper text-white font-bold text-xl shadow-2xl border-4 border-white">
                            1
                        </div>
                    </div>
                    <span class="ml-3 text-base font-extrabold bg-gradient-to-r from-accent-DEFAULT via-accent-amber to-accent-copper bg-clip-text text-transparent">Basic Info</span>
                </div>
                <div class="flex-1 h-2 bg-gradient-to-r from-yellow-200 via-orange-200 to-gray-300 max-w-[120px] rounded-full shadow-inner"></div>
                                
                <!-- Step 2 - Inactive with Colorful Gradient -->
                <div class="flex items-center transform transition-all hover:scale-105">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 text-white font-bold text-xl shadow-xl opacity-50">
                        2
                    </div>
                    <span class="ml-3 text-base font-semibold text-gray-600">Services</span>
                </div>
                <div class="flex-1 h-2 bg-gradient-to-r from-gray-300 to-gray-200 max-w-[120px] rounded-full shadow-inner"></div>
                
                <!-- Step 3 - Inactive with Colorful Gradient -->
                <div class="flex items-center transform transition-all hover:scale-105">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-teal-500 text-white font-bold text-xl shadow-xl opacity-50">
                        3
                    </div>
                    <span class="ml-3 text-base font-semibold text-gray-600">Photos</span>
                </div>
            </div>
        </div>

        <!-- Form Card with Vibrant Background -->
        <div class="relative bg-gradient-to-br from-white via-kairouan-beige/60 to-accent-copper/30 backdrop-blur-lg rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden hover:shadow-gold transition-all duration-500">
            <!-- Decorative Background Patterns -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-accent-amber/20 to-transparent rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-accent-copper/20 to-transparent rounded-full blur-3xl"></div>
            
            <!-- Card Header with Rainbow Gradient -->
            <div class="relative bg-gradient-to-r from-accent-DEFAULT via-accent-amber via-orange-500 to-accent-copper px-10 py-10 overflow-hidden">
                <div class="absolute inset-0 opacity-30">
                    <div class="absolute inset-0 animate-pulse" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 15px, rgba(255,255,255,0.15) 15px, rgba(255,255,255,0.15) 30px);"></div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/30 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-4xl font-extrabold text-white drop-shadow-2xl">{{ __('onboarding.step1.title') }}</h1>
                    </div>
                    <p class="text-white/95 text-lg font-medium">Tell us about yourself and let your business shine ✨</p>
                </div>
            </div>

            <!-- Form Body with Colorful Inputs -->
            <form method="POST" action="{{ route('provider.store') }}" class="relative z-10 p-10 space-y-7" id="providerForm">
                @csrf
                
                <!-- Field of Work (Category) - NEW with Rainbow Gradient -->
                <div class="transform transition-all duration-300 hover:scale-[1.02] bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 rounded-3xl p-6 border-4 border-purple-300 shadow-xl">
                    <label for="category_id" class="block text-2xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                        <span class="flex items-center">
                            <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Field of Work <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <select id="category_id" name="category_id" required
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-purple-400 focus:border-purple-600 focus:ring-8 focus:ring-purple-600/30 bg-white shadow-lg transition-all duration-300 font-bold text-gray-800">
                        <option value="">-- Select your field of work --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                                @if($category->description) - {{ $category->description }}@endif
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-3" />
                    <p class="mt-3 text-base font-bold text-purple-700 bg-purple-100 p-4 rounded-xl border-2 border-purple-300 flex items-center">
                        <svg class="w-6 h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>This will determine which services you can offer in the next step! 🎯</span>
                    </p>
                </div>
                
                <!-- Display Name with Gold Border -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <label for="display_name" class="block text-lg font-extrabold bg-gradient-to-r from-accent-DEFAULT to-accent-amber bg-clip-text text-transparent mb-3">
                        {{ __('onboarding.fields.display_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input id="display_name" name="display_name" type="text" required
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-accent-DEFAULT/50 focus:border-accent-DEFAULT focus:ring-8 focus:ring-accent-DEFAULT/30 bg-white/80 backdrop-blur-sm shadow-lg transition-all duration-300 font-medium"
                        placeholder="Your business or professional name">
                    <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                </div>

                <!-- City with Amber Border -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <label for="city" class="block text-lg font-extrabold bg-gradient-to-r from-orange-500 to-amber-600 bg-clip-text text-transparent mb-3">
                        {{ __('onboarding.fields.city') }} <span class="text-red-500">*</span>
                    </label>
                    <input id="city" name="city" type="text" required
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-orange-300 focus:border-orange-500 focus:ring-8 focus:ring-orange-500/30 bg-white/80 backdrop-blur-sm shadow-lg transition-all duration-300 font-medium"
                        placeholder="Kairouan">
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <!-- Bio with Copper Border -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <label for="bio" class="block text-lg font-extrabold bg-gradient-to-r from-accent-copper to-amber-700 bg-clip-text text-transparent mb-3">
                        {{ __('onboarding.fields.bio') }}
                    </label>
                    <textarea id="bio" name="bio" rows="5"
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-amber-300 focus:border-amber-500 focus:ring-8 focus:ring-amber-500/30 bg-white/80 backdrop-blur-sm shadow-lg transition-all duration-300 font-medium"
                        placeholder="Tell us about your services and experience... ✍️"></textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <!-- Website with Blue Border -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <label for="website" class="block text-lg font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                        {{ __('onboarding.fields.website') }}
                    </label>
                    <input id="website" name="website" type="url"
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-blue-300 focus:border-blue-500 focus:ring-8 focus:ring-blue-500/30 bg-white/80 backdrop-blur-sm shadow-lg transition-all duration-300 font-medium"
                        placeholder="https://example.com 🌐">
                    <x-input-error :messages="$errors->get('website')" class="mt-2" />
                </div>

                <!-- Skills with Green Border -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <label for="skills" class="block text-lg font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-3">
                        {{ __('onboarding.fields.skills') }}
                    </label>
                    <input id="skills" name="skills" type="text"
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-green-300 focus:border-green-500 focus:ring-8 focus:ring-green-500/30 bg-white/80 backdrop-blur-sm shadow-lg transition-all duration-300 font-medium"
                        placeholder="e.g. plumbing, design, electrical 🛠️">
                    <p class="mt-2 text-sm font-medium text-gray-600 ml-2">Separate skills with commas</p>
                </div>

                <!-- Cities Served with Teal Border -->
                <div class="transform transition-all duration-300 hover:scale-[1.02]">
                    <label for="cities" class="block text-lg font-extrabold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent mb-3">
                        {{ __('onboarding.fields.cities') }}
                    </label>
                    <input id="cities" name="cities" type="text"
                        class="w-full px-6 py-4 text-lg rounded-2xl border-4 border-teal-300 focus:border-teal-500 focus:ring-8 focus:ring-teal-500/30 bg-white/80 backdrop-blur-sm shadow-lg transition-all duration-300 font-medium"
                        placeholder="Kairouan, Tunis, Sousse 🗺️">
                    <p class="mt-2 text-sm font-medium text-gray-600 ml-2">Separate cities with commas</p>
                </div>

                <!-- Social Media Section with Vibrant Colors -->
                <div class="bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 rounded-3xl p-8 border-4 border-purple-200 shadow-xl">
                    <h3 class="text-2xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-600 to-orange-600 bg-clip-text text-transparent mb-6 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Social Media Links (Optional) 🚀
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Facebook -->
                        <div class="transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center gap-3 bg-white rounded-2xl p-4 border-3 border-blue-200 hover:border-blue-500 hover:shadow-lg transition-all">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <input name="social[facebook]" type="url"
                                    class="flex-1 px-4 py-3 text-base rounded-xl border-2 border-transparent focus:border-blue-400 focus:ring-4 focus:ring-blue-400/30 bg-gray-50 transition-all font-medium"
                                    placeholder="Facebook URL">
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center gap-3 bg-white rounded-2xl p-4 border-3 border-pink-200 hover:border-pink-500 hover:shadow-lg transition-all">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-pink-500 via-purple-500 to-orange-500 flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                                <input name="social[instagram]" type="url"
                                    class="flex-1 px-4 py-3 text-base rounded-xl border-2 border-transparent focus:border-pink-400 focus:ring-4 focus:ring-pink-400/30 bg-gray-50 transition-all font-medium"
                                    placeholder="Instagram URL">
                            </div>
                        </div>

                        <!-- TikTok -->
                        <div class="transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center gap-3 bg-white rounded-2xl p-4 border-3 border-gray-200 hover:border-gray-600 hover:shadow-lg transition-all">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-gray-900 to-gray-700 flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                    </svg>
                                </div>
                                <input name="social[tiktok]" type="url"
                                    class="flex-1 px-4 py-3 text-base rounded-xl border-2 border-transparent focus:border-gray-500 focus:ring-4 focus:ring-gray-500/30 bg-gray-50 transition-all font-medium"
                                    placeholder="TikTok URL">
                            </div>
                        </div>

                        <!-- LinkedIn -->
                        <div class="transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center gap-3 bg-white rounded-2xl p-4 border-3 border-blue-200 hover:border-blue-700 hover:shadow-lg transition-all">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </div>
                                <input name="social[linkedin]" type="url"
                                    class="flex-1 px-4 py-3 text-base rounded-xl border-2 border-transparent focus:border-blue-600 focus:ring-4 focus:ring-blue-600/30 bg-gray-50 transition-all font-medium"
                                    placeholder="LinkedIn URL">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions with Vibrant Buttons -->
                <div class="mt-10 flex items-center justify-between pt-8 border-t-4 border-gradient-to-r from-accent-DEFAULT to-accent-amber">
                    <a href="{{ route('home') }}" class="group px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-300">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Cancel
                        </span>
                    </a>
                    <button type="submit" class="group relative px-10 py-5 bg-gradient-to-r from-accent-DEFAULT via-accent-amber via-orange-500 to-accent-copper text-white font-extrabold text-xl rounded-2xl shadow-2xl hover:shadow-gold hover:scale-110 transition-all duration-300 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            {{ __('onboarding.buttons.next') }}
                            <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Text with Colorful Icon -->
        <div class="mt-8 text-center bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border-2 border-blue-200 shadow-lg">
            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-base font-bold text-gray-700">
                    Need help? Contact us at <a href="mailto:support@kairouanhub.com" class="text-blue-600 hover:text-purple-600 underline transition-colors">support@kairouanhub.com</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('providerForm');
    
    form.addEventListener('submit', function(e) {
        // Get the skills input
        const skillsInput = document.getElementById('skills');
        const citiesInput = document.getElementById('cities');
        
        // Convert comma-separated strings to arrays
        if (skillsInput && skillsInput.value.trim()) {
            const skillsArray = skillsInput.value.split(',').map(s => s.trim()).filter(s => s.length > 0);
            
            // Remove the original input temporarily
            skillsInput.disabled = true;
            
            // Add hidden inputs for each skill
            skillsArray.forEach((skill, index) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `skills[${index}]`;
                hiddenInput.value = skill;
                form.appendChild(hiddenInput);
            });
        }
        
        if (citiesInput && citiesInput.value.trim()) {
            const citiesArray = citiesInput.value.split(',').map(c => c.trim()).filter(c => c.length > 0);
            
            // Remove the original input temporarily
            citiesInput.disabled = true;
            
            // Add hidden inputs for each city
            citiesArray.forEach((city, index) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `cities[${index}]`;
                hiddenInput.value = city;
                form.appendChild(hiddenInput);
            });
        }
    });
});
</script>
@endsection
