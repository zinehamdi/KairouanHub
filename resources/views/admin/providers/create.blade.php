@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-kairouan-warm-cream py-12 pb-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.providers.index') }}" 
                   class="text-white bg-gradient-to-r from-[#E07A5F] to-[#F4A261] hover:from-[#F4A261] hover:to-[#E07A5F] p-2 rounded-lg transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-brand-dark">Add New Provider</h1>
                    <p class="text-gray-600 mt-1">إضافة مزود خدمة جديد</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form action="{{ route('admin.providers.store') }}" method="POST" x-data="{ selectedServices: [], showFloatingButton: false }" @scroll.window="showFloatingButton = window.scrollY > 200">
                @csrf

                <!-- User Information -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" style="color: #E07A5F;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        User Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-brand-dark mb-2">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-brand-dark mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-brand-dark mb-2">Password *</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-brand-dark mb-2">Confirm Password *</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-brand-dark mb-2">Phone *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-brand-dark mb-2">City</label>
                            <input type="text" name="city" value="{{ old('city', 'Kairouan') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-brand-dark mb-2">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-brand-dark mb-2">Bio</label>
                        <textarea name="bio" rows="3"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">{{ old('bio') }}</textarea>
                    </div>
                </div>

                <!-- Services -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-brand-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" style="color: #E07A5F;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Services Offered *
                    </h3>
                    @error('services')
                        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @foreach($services as $categoryName => $categoryServices)
                        <div class="mb-6">
                            <h4 class="font-bold text-brand-dark mb-3 text-lg flex items-center gap-2">
                                <span>{{ $categoryName }}</span>
                                <span class="text-sm font-normal text-gray-500">({{ $categoryServices->count() }} services)</span>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($categoryServices as $service)
                                    <label class="relative flex items-start p-3 border-2 border-gray-200 rounded-xl hover:border-[#E07A5F] transition-all cursor-pointer"
                                           :class="selectedServices.includes({{ $service->id }}) ? 'border-[#E07A5F] bg-gradient-to-r from-[#E07A5F]/5 to-[#F4A261]/5' : ''">
                                        <input type="checkbox" 
                                               name="services[]" 
                                               value="{{ $service->id }}"
                                               x-model="selectedServices"
                                               class="mt-1 h-5 w-5 rounded focus:ring-[#E07A5F]"
                                               style="color: #E07A5F; border-color: #E07A5F;">
                                        <div class="ml-3 flex-1">
                                            <p class="font-semibold text-brand-dark text-sm">{{ $service->name }}</p>
                                            @if($service->name_ar)
                                                <p class="text-xs text-gray-500">{{ $service->name_ar }}</p>
                                            @endif
                                        </div>
                                        <svg x-show="selectedServices.includes({{ $service->id }})" 
                                             class="absolute top-2 right-2 w-5 h-5 text-[#E07A5F]" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.providers.index') }}" 
                       class="px-6 py-3 border-2 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all"
                       style="border-color: #E07A5F;">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105"
                            style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
                        Create Provider
                    </button>
                </div>

                <!-- Floating Submit Button -->
                <div x-show="showFloatingButton" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     class="fixed bottom-6 right-6 z-50 flex items-center gap-3">
                    <a href="{{ route('admin.providers.index') }}" 
                       class="px-6 py-4 bg-white border-2 text-gray-700 font-semibold rounded-full shadow-2xl hover:shadow-xl transition-all hover:scale-105"
                       style="border-color: #E07A5F;">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-4 text-white font-bold rounded-full shadow-2xl hover:shadow-xl transition-all transform hover:scale-110 flex items-center gap-2"
                            style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Create Provider</span>
                        <span x-show="selectedServices.length > 0" 
                              class="ml-2 px-2.5 py-0.5 bg-white/20 rounded-full text-sm">
                            <span x-text="selectedServices.length"></span> services
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
