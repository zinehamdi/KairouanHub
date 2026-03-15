@extends('layouts.app')

@section('title', __('admin.map_import_title', ['default' => 'Import Provider from Map']))

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        [x-cloak] {
            display: none !important;
        }

        .leaflet-container {
            font-family: inherit;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-kairouan-warm-cream">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-brand-dark to-deep-blue py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">📍
                            {{ __('admin.map_import_title', ['default' => 'Add Provider with Map Location']) }}
                        </h1>
                        <p class="text-white/80 mt-1">
                            {{ __('admin.map_import_subtitle_manual', ['default' => 'Click on the map to set the exact location for the new provider']) }}
                        </p>
                    </div>
                    <a href="{{ route('admin.providers.index') }}"
                        class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all">
                        ← {{ __('buttons.back', ['default' => 'Back']) }}
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="mapImport()">
            {{-- Success Message --}}
            <div x-show="success" x-cloak class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 font-medium" x-text="success"></span>
                    <button @click="success = null" class="ml-auto text-green-500 hover:text-green-700">✕</button>
                </div>
            </div>

            {{-- Error Message --}}
            <div x-show="error" x-cloak class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-red-800 font-medium" x-text="error"></span>
                    <button @click="error = null" class="ml-auto text-red-500 hover:text-red-700">✕</button>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-4">
                {{-- Map Section - LARGER --}}
                <div class="lg:w-2/3 w-full">
                    <div class="card-mediterranean p-3">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-bold text-brand-dark">📍 خريطة القيروان</h2>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">اضغط لتحديد الموقع</span>
                        </div>

                        {{-- BIG Map Container --}}
                        <div id="map" class="w-full rounded-xl overflow-hidden border-2 border-accent-DEFAULT/30 shadow-lg" style="height: 65vh; min-height: 500px;"></div>

                        {{-- Selected Location Display --}}
                        <div x-show="formData.lat && formData.lng" x-cloak
                            class="mt-3 p-2 bg-green-50 rounded-lg border border-green-200 text-sm">
                            <span class="text-green-700 font-bold">✅ تم التحديد:</span>
                            <span class="text-gray-600" x-text="formData.address ? formData.address.substring(0, 40) + '...' : ''"></span>
                        </div>
                    </div>
                </div>

                {{-- Form Section - SIDE PANEL --}}
                <div class="lg:w-1/3 w-full">
                    <div class="card-mediterranean p-4 lg:sticky lg:top-4">
                        <h2 class="text-lg font-bold text-brand-dark mb-3 flex items-center gap-2">
                            📝 {{ __('admin.provider_details', ['default' => 'بيانات المزود']) }}
                        </h2>

                        <form @submit.prevent="submitForm()" class="space-y-3">
                            {{-- Business Name --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.business_name', ['default' => 'Business Name']) }} *
                                </label>
                                <input type="text" x-model="formData.name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-DEFAULT focus:border-transparent"
                                    placeholder="{{ __('admin.business_name_placeholder', ['default' => 'e.g., Restaurant El Kairouan']) }}">
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.phone', ['default' => 'Phone']) }}
                                </label>
                                <input type="text" x-model="formData.phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-DEFAULT focus:border-transparent"
                                    placeholder="{{ __('admin.phone_placeholder', ['default' => 'e.g., +216 XX XXX XXX']) }}">
                            </div>

                            {{-- Address --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.address', ['default' => 'Address']) }}
                                </label>
                                <textarea x-model="formData.address" rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-DEFAULT focus:border-transparent"
                                    placeholder="{{ __('admin.address_placeholder', ['default' => 'e.g., Rue Ibn Khaldoun, Kairouan']) }}"></textarea>
                            </div>

                            {{-- City --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.city', ['default' => 'City']) }}
                                </label>
                                <input type="text" x-model="formData.city"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-DEFAULT focus:border-transparent"
                                    placeholder="Kairouan">
                            </div>

                            {{-- Category --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.category', ['default' => 'Category']) }}
                                </label>
                                <select x-model="formData.category_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-DEFAULT focus:border-transparent">
                                    <option value="">{{ __('admin.select_category', ['default' => 'Select a category']) }}
                                    </option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->localized_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Website --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.website', ['default' => 'Website']) }}
                                </label>
                                <input type="url" x-model="formData.website"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-DEFAULT focus:border-transparent"
                                    placeholder="https://...">
                            </div>

                            {{-- Coordinates (Read-only) --}}
                            <div x-show="formData.lat && formData.lng">
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    {{ __('admin.coordinates', ['default' => 'Coordinates']) }}
                                </label>
                                <div class="px-4 py-3 bg-gray-50 rounded-xl text-sm text-gray-600">
                                    📍 <span x-text="formData.lat?.toFixed(6)"></span>, <span
                                        x-text="formData.lng?.toFixed(6)"></span>
                                </div>
                            </div>

                            {{-- Location Warning --}}
                            <div x-show="!formData.lat || !formData.lng"
                                class="p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <div class="flex items-center gap-2 text-yellow-800 text-sm">
                                    <span>⚠️</span>
                                    <span>{{ __('admin.location_required_tip', ['default' => 'Click on the map to set the provider location (optional but recommended)']) }}</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-3 pt-4 border-t border-gray-200">
                                <a href="{{ route('admin.providers.index') }}"
                                    class="flex-1 py-3 px-6 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-center">
                                    {{ __('buttons.cancel', ['default' => 'Cancel']) }}
                                </a>
                                <button type="submit" :disabled="importing"
                                    class="flex-1 py-3 px-6 bg-accent-DEFAULT hover:bg-accent-amber text-white font-bold rounded-xl transition-all disabled:opacity-50">
                                    <span x-show="!importing">✅
                                        {{ __('admin.create_provider', ['default' => 'Create Provider']) }}</span>
                                    <span x-show="importing" class="flex items-center justify-center">
                                        <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        {{ __('buttons.creating', ['default' => 'Creating...']) }}
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leaflet JS (FREE - No API Key Required) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>    
                let map;
            let     marker = null;

                  function mapImport() {
                return {
                    formData: {
                        name: '',
                        phone: '',
                        address: '',
                        city: 'Kairouan',
                        website: '',
                        category_id: '',
                        lat: null,
                        lng: null
                    },
                    importing: false,
                    error: null,
                    success: null,

                    init() {
                        this.$nextTick(() => {
                            this.initMap();
                        });
                    },

                    initMap() {
                        // Kairouan city center
                        const kairouan = [35.6781, 10.0963];
                        
                        // Kairouan Governorate bounds - lock map to this area!
                        const kairouanBounds = L.latLngBounds(
                            [35.45, 9.75],   // Southwest
                            [35.90, 10.35]   // Northeast
                        );

                        // Create map locked to Kairouan only
                        map = L.map('map', {
                            zoomControl: true,
                            scrollWheelZoom: true,
                            doubleClickZoom: true,
                            zoomAnimation: true,
                            fadeAnimation: true,
                            markerZoomAnimation: true,
                            maxBounds: kairouanBounds,
                            maxBoundsViscosity: 1.0
                        }).setView(kairouan, 15);

                        // Add smooth OpenStreetMap tiles
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            minZoom: 10,
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map);

                        // Small center indicator (not distracting)
                        L.circleMarker(kairouan, {
                            radius: 6,
                            fillColor: '#D4AF37',
                            color: '#B87333',
                            weight: 1,
                            opacity: 0.7,
                            fillOpacity: 0.5
                        }).addTo(map).bindPopup('<b>القيروان</b>');

                        // Click to place marker with smooth zoom
                        map.on('click', (e) => {
                            this.placeMarker(e.latlng.lat, e.latlng.lng);
                            // Smooth zoom to clicked location
                            map.flyTo([e.latlng.lat, e.latlng.lng], 17, {
                                duration: 0.5
                            });
                        });
                    },

                    placeMarker(lat, lng) {
                        // Remove existing marker
                        if (marker) {
                            map.removeLayer(marker);
                        }

                        // Add new marker
                        marker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map);

                        marker.bindPopup(`<b>📍 ${this.formData.name || '{{ __("admin.new_provider", ["default" => "New Provider"]) }}'}</b><br>{{ __("admin.drag_to_adjust", ["default" => "Drag to adjust location"]) }}`).openPopup();

                        // Update form data
                        this.formData.lat = lat;
                        this.formData.lng = lng;

                        // Auto-fill address using Nominatim (FREE - Snap Map style!)
                        this.reverseGeocode(lat, lng);

                        // Update on drag
                        marker.on('dragend', (e) => {
                            const pos = e.target.getLatLng();
                            this.formData.lat = pos.lat;
                            this.formData.lng = pos.lng;
                            // Also update address on drag
                            this.reverseGeocode(pos.lat, pos.lng);
                        });
                    },

                    // Snap Map-like: Auto-detect address from coordinates (FREE Nominatim API)
                    async reverseGeocode(lat, lng) {
                        try {
                            const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=ar,en&addressdetails=1`;
                            const response = await fetch(url, {
                                headers: {
                                    'User-Agent': 'KairouanHub/1.0 (admin-map-import)'
                                }
                            });

                            if (!response.ok) return;

                            const data = await response.json();

                            if (data && data.display_name) {
                                // Auto-fill address
                                this.formData.address = data.display_name;

                                // Auto-fill city from address details
                                if (data.address) {
                                    const city = data.address.city || data.address.town || data.address.village || data.address.municipality || 'Kairouan';
                                    this.formData.city = city;
                                }

                                // Update popup with the address
                                if (marker) {
                                    marker.setPopupContent(`<b>📍 ${this.formData.name || '{{ __("admin.new_provider", ["default" => "New Provider"]) }}'}</b><br><small>${data.display_name.substring(0, 60)}...</small>`);
                                }
                            }
                        } catch (error) {
                            console.log('Reverse geocoding failed, continuing without auto-fill:', error);
                        }
                    },

                    async submitForm() {
                        if (!this.formData.name?.trim()) {
                            this.error = '{{ __("admin.name_required", ["default" => "Business name is required"]) }}';
                            return;
                        }

                        this.importing = true;
                        this.error = null;

                        try {
                            const response = await fetch('{{ route("admin.providers.confirm-import") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(this.formData)
                            });

                            const data = await response.json();

                            if (data.success) {
                                window.location.href = '{{ route("admin.providers.index") }}?success=' + encodeURIComponent(data.message);
                            } else {
                                this.error = data.message || '{{ __("admin.import_failed", ["default" => "Failed to create provider"]) }}';
                            }
                        } catch (error) {
                            console.error(error);
                            this.error = '{{ __("admin.import_error", ["default" => "An error occurred"]) }}';
                        } finally {
                            this.importing = false;
                        }
                    }
                };
            }
        </script>
@endsection