@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-kairouan-warm-cream py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-flash />

            <!-- Progress Steps -->
            <div class="mb-10">
                <div class="flex items-center justify-center gap-4">
                    <!-- Step 1 - Active -->
                    <div class="flex items-center">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white font-bold text-lg shadow-soft">
                            1
                        </div>
                        <span class="ml-3 text-sm font-bold text-accent-DEFAULT">Basic Info</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 max-w-[100px] rounded-full"></div>

                    <!-- Step 2 - Inactive -->
                    <div class="flex items-center">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-300 text-white font-bold text-lg">
                            2
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-500">Services</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 max-w-[100px] rounded-full"></div>

                    <!-- Step 3 - Inactive -->
                    <div class="flex items-center">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-300 text-white font-bold text-lg">
                            3
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-500">Photos</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card-mediterranean overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-accent-DEFAULT to-accent-amber px-8 py-10">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-white">{{ __('onboarding.step1.title') }}</h1>
                    </div>
                    <p class="text-white/95 text-lg">Tell us about yourself and your business</p>
                </div>

                <!-- Form Body -->
                <form method="POST" action="{{ route('provider.store') }}" class="p-8 space-y-6" id="providerForm">
                    @csrf

                    <!-- Field of Work -->
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-brand-dark mb-2">
                            Field of Work <span class="text-accent-DEFAULT">*</span>
                        </label>
                        <select id="category_id" name="category_id" required class="input-mediterranean">
                            <option value="">-- Select your field of work --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                    @if($category->description) - {{ $category->description }}@endif
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        <p class="mt-2 text-sm text-gray-600">
                            This will determine which services you can offer in the next step
                        </p>
                    </div>

                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-bold text-brand-dark mb-2">
                            {{ __('onboarding.fields.display_name') }} <span class="text-accent-DEFAULT">*</span>
                        </label>
                        <input id="display_name" name="display_name" type="text" required class="input-mediterranean"
                            placeholder="Your business or professional name">
                        <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-bold text-brand-dark mb-2">
                            {{ __('onboarding.fields.city') }} <span class="text-accent-DEFAULT">*</span>
                        </label>
                        <input id="city" name="city" type="text" required class="input-mediterranean"
                            placeholder="Kairouan">
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-bold text-brand-dark mb-2">
                            {{ __('onboarding.fields.bio') }}
                        </label>
                        <textarea id="bio" name="bio" rows="4" class="input-mediterranean"
                            placeholder="Tell us about your services and experience..."></textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-bold text-brand-dark mb-2">
                            {{ __('onboarding.fields.website') }}
                        </label>
                        <input id="website" name="website" type="url" class="input-mediterranean"
                            placeholder="https://example.com">
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="block text-sm font-bold text-brand-dark mb-2">
                            {{ __('onboarding.fields.skills') }}
                        </label>
                        <input id="skills" type="text" class="input-mediterranean"
                            placeholder="e.g. plumbing, design, electrical">
                        <p class="mt-2 text-sm text-gray-600">Separate skills with commas</p>
                    </div>

                    <!-- Cities Served -->
                    <div>
                        <label for="cities" class="block text-sm font-bold text-brand-dark mb-2">
                            {{ __('onboarding.fields.cities') }}
                        </label>
                        <input id="cities" type="text" class="input-mediterranean"
                            placeholder="Kairouan, Tunis, Sousse">
                        <p class="mt-2 text-sm text-gray-600">Separate cities with commas</p>
                    </div>

                    <!-- Social Media Section -->
                    <div class="bg-kairouan-warm-cream rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-brand-dark mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Social Media Links (Optional)
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Facebook -->
                            <div>
                                <input name="social[facebook]" type="url" class="input-mediterranean"
                                    placeholder="Facebook URL">
                            </div>

                            <!-- Instagram -->
                            <div>
                                <input name="social[instagram]" type="url" class="input-mediterranean"
                                    placeholder="Instagram URL">
                            </div>

                            <!-- TikTok -->
                            <div>
                                <input name="social[tiktok]" type="url" class="input-mediterranean"
                                    placeholder="TikTok URL">
                            </div>

                            <!-- LinkedIn -->
                            <div>
                                <input name="social[linkedin]" type="url" class="input-mediterranean"
                                    placeholder="LinkedIn URL">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('home') }}" class="btn-outline-mediterranean">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn-terracotta">
                            {{ __('onboarding.buttons.next') }}
                            <svg class="w-5 h-5 ml-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Text -->
            <div class="mt-6 text-center bg-white rounded-xl p-4 shadow-soft">
                <p class="text-sm text-gray-600">
                    Need help? Contact us at <a href="mailto:support@kairouanhub.com"
                        class="text-accent-DEFAULT hover:text-mediterranean-blue underline">support@kairouanhub.com</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('providerForm');

            form.addEventListener('submit', function (e) {
                const skillsInput = document.getElementById('skills');
                const citiesInput = document.getElementById('cities');

                if (skillsInput && skillsInput.value.trim()) {
                    const skillsArray = skillsInput.value.split(',').map(s => s.trim()).filter(s => s.length > 0);
                    skillsInput.disabled = true;

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
                    citiesInput.disabled = true;

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