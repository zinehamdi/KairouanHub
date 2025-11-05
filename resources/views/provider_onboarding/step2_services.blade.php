@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-cover bg-center bg-fixed py-12" style="background-image: linear-gradient(135deg, rgba(139, 195, 74, 0.25), rgba(156, 39, 176, 0.20), rgba(63, 81, 181, 0.25)), url('{{ asset('images/kairouan-background.jpg') }}');">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-flash />
        
        <!-- Wizard Progress Header with Vibrant Colors -->
        <div class="mb-10">
            <div class="flex items-center justify-center space-x-4">
                <!-- Step 1 - Completed with Green Checkmark -->
                <div class="flex items-center transform transition-all hover:scale-105">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-green-400 via-emerald-500 to-green-600 text-white font-bold shadow-2xl border-4 border-white">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="ml-3 text-base font-bold text-green-700">Basic Info</span>
                </div>
                <div class="flex-1 h-2 bg-gradient-to-r from-green-400 via-purple-300 to-purple-400 max-w-[120px] rounded-full shadow-inner"></div>
                
                <!-- Step 2 - Active with Purple Animation -->
                <div class="flex items-center transform transition-all hover:scale-110">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full blur-xl opacity-60 animate-pulse"></div>
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 via-indigo-600 to-purple-700 text-white font-bold text-xl shadow-2xl border-4 border-white">
                            2
                        </div>
                    </div>
                    <span class="ml-3 text-base font-extrabold bg-gradient-to-r from-purple-600 to-indigo-700 bg-clip-text text-transparent">Services</span>
                </div>
                <div class="flex-1 h-2 bg-gradient-to-r from-gray-300 to-gray-200 max-w-[120px] rounded-full shadow-inner"></div>
                
                <!-- Step 3 - Inactive -->
                <div class="flex items-center transform transition-all hover:scale-105">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 text-white font-bold text-xl shadow-xl opacity-50">
                        3
                    </div>
                    <span class="ml-3 text-base font-semibold text-gray-600">Photos</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="relative bg-gradient-to-br from-white via-purple-50 to-indigo-50 backdrop-blur-lg rounded-3xl shadow-2xl border-4 border-white/50 overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-br from-purple-300/30 to-transparent rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-gradient-to-tr from-indigo-300/30 to-transparent rounded-full blur-3xl"></div>
            
            <!-- Card Header -->
            <div class="relative bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-700 px-10 py-10 overflow-hidden">
                <div class="absolute inset-0 opacity-30">
                    <div class="absolute inset-0 animate-pulse" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 15px, rgba(255,255,255,0.15) 15px, rgba(255,255,255,0.15) 30px);"></div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/30 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h1 class="text-4xl font-extrabold text-white drop-shadow-2xl">{{ __('onboarding.step2.title') }}</h1>
                    </div>
                    <p class="text-white/95 text-lg font-medium">Select your services and set competitive prices 💼</p>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('provider.services.store') }}" class="relative z-10 p-10 space-y-7" id="servicesForm">
                @csrf
                
                <div class="mb-6 p-5 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-2xl border-2 border-purple-300">
                    <p class="text-base font-bold text-purple-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Select services you offer and set individual prices for each
                    </p>
                </div>
                
                <!-- Services grouped by category -->
                <div class="space-y-8">
                    @foreach($categories as $category)
                        <div class="bg-gradient-to-br from-white via-purple-50/30 to-indigo-50/20 rounded-3xl p-6 border-4 border-purple-200/50 shadow-xl">
                            <!-- Category Header -->
                            <div class="mb-6 pb-4 border-b-4 border-purple-300">
                                <h3 class="text-2xl font-extrabold bg-gradient-to-r from-purple-600 to-indigo-700 bg-clip-text text-transparent flex items-center">
                                    <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $category->name }}
                                </h3>
                                @if($category->description)
                                    <p class="text-base text-gray-600 ml-11 mt-1 font-medium">{{ $category->description }}</p>
                                @endif
                            </div>
                            
                            <!-- Services in this category -->
                            <div class="space-y-4">
                                @php $categoryIndex = $loop->index; @endphp
                                @foreach($category->services as $service)
                                    @php $serviceGlobalIndex = $categoryIndex * 100 + $loop->index; @endphp
                                    <div class="service-item transform transition-all duration-300 hover:scale-[1.02] border-4 border-transparent hover:border-purple-400 rounded-2xl p-5 bg-gradient-to-br from-white via-purple-50/50 to-indigo-50/30 shadow-lg hover:shadow-2xl">
                                        <label class="flex items-center gap-4 cursor-pointer mb-4">
                                            <div class="relative">
                                                <input type="checkbox" value="{{ $service->id }}"
                                                    class="service-checkbox peer w-8 h-8 rounded-lg border-3 border-purple-300 text-purple-600 focus:ring-4 focus:ring-purple-500/30 transition-all cursor-pointer"
                                                    data-service-id="{{ $service->id }}" 
                                                    data-service-name="{{ $service->name }}" />
                                                <svg class="absolute top-1 left-1 w-6 h-6 text-white pointer-events-none hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <span class="text-xl font-extrabold bg-gradient-to-r from-purple-700 to-indigo-700 bg-clip-text text-transparent">{{ $service->name }}</span>
                                        </label>
                                        <div class="price-inputs grid grid-cols-1 md:grid-cols-2 gap-5 ml-12 opacity-50 pointer-events-none" data-service-id="{{ $service->id }}">
                                            <div class="transform transition-all hover:scale-105">
                                                <label class="block text-base font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">Min Price (TND) 💵</label>
                                                <input type="number" min="0" step="1"
                                                    class="price-min w-full px-5 py-3 text-lg rounded-xl border-3 border-green-300 focus:border-green-500 focus:ring-4 focus:ring-green-500/30 bg-white shadow-md transition-all font-medium"
                                                    placeholder="0" />
                                            </div>
                                            <div class="transform transition-all hover:scale-105">
                                                <label class="block text-base font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">Max Price (TND) 💰</label>
                                                <input type="number" min="0" step="1"
                                                    class="price-max w-full px-5 py-3 text-lg rounded-xl border-3 border-orange-300 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/30 bg-white shadow-md transition-all font-medium"
                                                    placeholder="0" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- No services selected message -->
                <div id="no-services-msg" class="p-5 bg-yellow-50 border-2 border-yellow-300 rounded-2xl hidden">
                    <p class="text-yellow-800 font-bold flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Please select at least one service
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="mt-10 flex items-center justify-between pt-8 border-t-4 border-purple-200">
                    <a href="{{ route('provider.start') }}" class="group px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-300">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </span>
                    </a>
                    <button type="submit" class="group relative px-10 py-5 bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-700 text-white font-extrabold text-xl rounded-2xl shadow-2xl hover:shadow-purple-500/50 hover:scale-110 transition-all duration-300 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            {{ __('onboarding.buttons.next') }}
                            <svg class="w-6 h-6 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('servicesForm');
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    
    // Enable/disable price inputs when checkbox is toggled
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const serviceId = this.dataset.serviceId;
            const priceInputs = document.querySelector(`.price-inputs[data-service-id="${serviceId}"]`);
            
            if (this.checked) {
                priceInputs.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                priceInputs.classList.add('opacity-50', 'pointer-events-none');
                // Clear the prices
                priceInputs.querySelector('.price-min').value = '';
                priceInputs.querySelector('.price-max').value = '';
            }
        });
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get all checked services
        const checkedServices = Array.from(serviceCheckboxes).filter(cb => cb.checked);
        
        if (checkedServices.length === 0) {
            document.getElementById('no-services-msg').classList.remove('hidden');
            alert('⚠️ Please select at least one service you offer!');
            return false;
        }
        
        document.getElementById('no-services-msg').classList.add('hidden');
        
        // Create hidden inputs for each selected service
        checkedServices.forEach((checkbox, index) => {
            const serviceId = checkbox.dataset.serviceId;
            const priceInputsDiv = document.querySelector(`.price-inputs[data-service-id="${serviceId}"]`);
            const priceMin = priceInputsDiv.querySelector('.price-min').value;
            const priceMax = priceInputsDiv.querySelector('.price-max').value;
            
            // Service ID
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `services[${index}][id]`;
            idInput.value = serviceId;
            form.appendChild(idInput);
            
            // Price min (if provided)
            if (priceMin) {
                const minInput = document.createElement('input');
                minInput.type = 'hidden';
                minInput.name = `services[${index}][price_min]`;
                minInput.value = Math.round(parseFloat(priceMin));
                form.appendChild(minInput);
            }
            
            // Price max (if provided)
            if (priceMax) {
                const maxInput = document.createElement('input');
                maxInput.type = 'hidden';
                maxInput.name = `services[${index}][price_max]`;
                maxInput.value = Math.round(parseFloat(priceMax));
                form.appendChild(maxInput);
            }
        });
        
        // Disable checkboxes and inputs to prevent sending them
        serviceCheckboxes.forEach(cb => cb.disabled = true);
        document.querySelectorAll('.price-min, .price-max').forEach(input => input.disabled = true);
        
        // Submit the form
        form.submit();
    });
});
</script>
@endsection
