@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-kairouan-warm-cream py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if(session('import_errors') && is_array(session('import_errors')))
            <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                <p class="font-bold mb-2">Import Warnings:</p>
                <ul class="list-disc list-inside">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-brand-dark mb-2">{{ __('superadmin.dashboard_title') }}</h1>
            <p class="text-gray-600">{{ __('superadmin.dashboard_subtitle') }}</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card-mediterranean p-6">
                <p class="text-gray-600 text-sm font-medium">{{ __('superadmin.stats.admins') }}</p>
                <p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_admins ?? 0 }}</p>
            </div>
            <div class="card-mediterranean p-6">
                <p class="text-gray-600 text-sm font-medium">{{ __('superadmin.stats.users') }}</p>
                <p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_users ?? 0 }}</p>
            </div>
            <div class="card-mediterranean p-6">
                <p class="text-gray-600 text-sm font-medium">{{ __('superadmin.stats.providers') }}</p>
                <p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_providers ?? 0 }}</p>
            </div>
            <div class="card-mediterranean p-6">
                <p class="text-gray-600 text-sm font-medium">{{ __('superadmin.stats.services') }}</p>
                <p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_services ?? 0 }}</p>
            </div>
            <div class="card-mediterranean p-6">
                <p class="text-gray-600 text-sm font-medium">{{ __('superadmin.stats.categories') }}</p>
                <p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_categories ?? 0 }}</p>
            </div>
            <div class="card-mediterranean p-6">
                <p class="text-gray-600 text-sm font-medium">{{ __('superadmin.stats.requests') }}</p>
                <p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_requests ?? 0 }}</p>
            </div>
        </div>

        <!-- Admin Management Section -->
        <div class="mb-8 card-mediterranean p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-brand-dark">{{ __('superadmin.manage_admins') }}</h2>
                <button onclick="document.getElementById('addAdminModal').classList.remove('hidden')" 
                        class="btn-terracotta">
                    + {{ __('superadmin.add_admin') }}
                </button>
            </div>

            <!-- Add Admin Modal -->
            <div id="addAdminModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-xl font-bold mb-4">{{ __('superadmin.add_new_admin') }}</h3>
                    <form action="{{ route('superadmin.admins.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('superadmin.admin_name') }}</label>
                            <input type="text" name="name" required 
                                   class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('superadmin.admin_email') }}</label>
                            <input type="email" name="email" required 
                                   class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('superadmin.admin_password') }}</label>
                            <input type="password" name="password" required 
                                   class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('superadmin.admin_password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="btn-terracotta flex-1">{{ __('superadmin.create_admin') }}</button>
                            <button type="button" onclick="document.getElementById('addAdminModal').classList.add('hidden')" 
                                    class="btn-outline-mediterranean flex-1">{{ __('buttons.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admins Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('superadmin.admin_name') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('superadmin.admin_email') }}</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('buttons.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins ?? [] as $admin)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $admin->name }}</td>
                                <td class="px-4 py-3">{{ $admin->email }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('superadmin.admins.destroy', $admin) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('{{ __('superadmin.remove_admin_confirm') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 text-sm">
                                            {{ __('superadmin.remove_admin') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-gray-500">{{ __('messages.no_results') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Platform Settings Section -->
        <div class="mb-8 card-mediterranean p-6">
            <h2 class="text-2xl font-bold text-brand-dark mb-4">{{ __('superadmin.platform_settings') }}</h2>
            <form action="{{ route('superadmin.settings.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('superadmin.site_name') }}</label>
                        <input type="text" name="site_name" 
                               value="{{ $settings['site_name'] ?? config('app.name') }}" 
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('superadmin.site_email') }}</label>
                        <input type="email" name="site_email" 
                               value="{{ $settings['site_email'] ?? '' }}" 
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('superadmin.site_phone') }}</label>
                        <input type="text" name="site_phone" 
                               value="{{ $settings['site_phone'] ?? '' }}" 
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('superadmin.contact_address') }}</label>
                        <input type="text" name="contact_address" 
                               value="{{ $settings['contact_address'] ?? '' }}" 
                               class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="maintenance_mode" value="1" 
                               {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }} 
                               class="mr-2">
                        <span class="text-sm font-medium">{{ __('superadmin.maintenance_mode') }}</span>
                    </label>
                </div>
                <button type="submit" class="btn-terracotta">{{ __('superadmin.save_settings') }}</button>
            </form>
        </div>

        <!-- Google Maps Import Section -->
        <div class="mb-8 card-mediterranean p-6">
            <h2 class="text-2xl font-bold text-brand-dark mb-4">{{ __('superadmin.import_providers') }}</h2>
            <p class="text-gray-600 mb-4">{{ __('superadmin.import_description') }}</p>
            
            <div x-data="googlePlacesImport()" class="space-y-4">
                <!-- Search Form -->
                <div class="flex gap-3">
                    <input type="text" x-model="searchQuery" 
                           @keyup.enter="searchPlaces()"
                           placeholder="Search for providers (e.g., doctor, plumber, restaurant)" 
                           class="flex-1 px-4 py-2 border rounded-lg">
                    <select x-model="selectedCategory" class="px-4 py-2 border rounded-lg">
                        <option value="">Select Category (Optional)</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button @click="searchPlaces()" 
                            :disabled="loading"
                            class="btn-terracotta">
                        <span x-show="!loading">Search</span>
                        <span x-show="loading">Searching...</span>
                    </button>
                </div>

                <!-- Error Message -->
                <div x-show="error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p x-text="error"></p>
                </div>

                <!-- Search Results -->
                <div x-show="results.length > 0" class="space-y-3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Search Results</h3>
                        <div>
                            <button @click="selectAll()" class="text-sm text-blue-600 hover:underline mr-3">Select All</button>
                            <button @click="deselectAll()" class="text-sm text-blue-600 hover:underline">Deselect All</button>
                        </div>
                    </div>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        <template x-for="(place, index) in results" :key="index">
                            <div class="border rounded-lg p-3 hover:bg-gray-50">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" x-model="selectedPlaces" :value="place.place_id" class="mt-1">
                                    <div class="flex-1">
                                        <h4 class="font-semibold" x-text="place.name"></h4>
                                        <p class="text-sm text-gray-600" x-text="place.address"></p>
                                        <div class="flex gap-4 mt-1 text-xs text-gray-500">
                                            <span x-show="place.rating">Rating: <span x-text="place.rating"></span></span>
                                            <span x-show="place.user_ratings_total">Reviews: <span x-text="place.user_ratings_total"></span></span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </template>
                    </div>
                    <button @click="importProviders()" 
                            :disabled="selectedPlaces.length === 0 || importing"
                            class="btn-terracotta w-full">
                        <span x-show="!importing">Import Selected (<span x-text="selectedPlaces.length"></span>)</span>
                        <span x-show="importing">Importing...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Users -->
            <div class="card-mediterranean p-6">
                <h3 class="text-xl font-bold text-brand-dark mb-4">Recent Users</h3>
                <div class="space-y-3">
                    @forelse($recent_users ?? [] as $user)
                        <div class="flex items-center justify-between p-3 bg-kairouan-warm-cream rounded-lg">
                            <div>
                                <p class="font-semibold text-brand-dark">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent users</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Providers -->
            <div class="card-mediterranean p-6">
                <h3 class="text-xl font-bold text-brand-dark mb-4">Recent Providers</h3>
                <div class="space-y-3">
                    @forelse($recent_providers ?? [] as $provider)
                        <div class="p-3 bg-kairouan-warm-cream rounded-lg">
                            <p class="font-semibold text-brand-dark">{{ $provider->display_name }}</p>
                            <p class="text-sm text-gray-600">{{ $provider->user->email ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $provider->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent providers</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Requests -->
            <div class="card-mediterranean p-6">
                <h3 class="text-xl font-bold text-brand-dark mb-4">Recent Requests</h3>
                <div class="space-y-3">
                    @forelse($recent_requests ?? [] as $request)
                        <div class="p-3 bg-kairouan-warm-cream rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold text-brand-dark">{{ $request->user->name ?? 'N/A' }}</p>
                                <span class="badge-{{ $request->status === 'pending' ? 'terracotta' : 'blue' }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $request->service->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $request->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent requests</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function googlePlacesImport() {
    return {
        searchQuery: '',
        selectedCategory: '',
        results: [],
        selectedPlaces: [],
        loading: false,
        importing: false,
        error: null,

        async searchPlaces() {
            if (!this.searchQuery.trim()) {
                this.error = 'Please enter a search query';
                return;
            }

            this.loading = true;
            this.error = null;
            this.results = [];
            this.selectedPlaces = [];

            try {
                const response = await fetch('{{ route("superadmin.google-places.search") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        query: this.searchQuery
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.results = data.results;
                    if (this.results.length === 0) {
                        this.error = 'No results found. Try a different search term.';
                    }
                } else {
                    this.error = data.message || 'An error occurred while searching';
                }
            } catch (error) {
                this.error = 'Failed to search. Please check your Google Places API key.';
                console.error(error);
            } finally {
                this.loading = false;
            }
        },

        selectAll() {
            this.selectedPlaces = this.results.map(r => r.place_id);
        },

        deselectAll() {
            this.selectedPlaces = [];
        },

        async importProviders() {
            if (this.selectedPlaces.length === 0) {
                this.error = 'Please select at least one provider to import';
                return;
            }

            this.importing = true;
            this.error = null;

            try {
                const formData = new FormData();
                formData.append('place_ids', JSON.stringify(this.selectedPlaces));
                if (this.selectedCategory) {
                    formData.append('category_id', this.selectedCategory);
                }

                const response = await fetch('{{ route("superadmin.google-places.import") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    const data = await response.json();
                    if (data.success) {
                        window.location.reload();
                    } else {
                        this.error = data.message || 'Failed to import providers';
                    }
                }
            } catch (error) {
                this.error = 'Failed to import providers. Please try again.';
                console.error(error);
            } finally {
                this.importing = false;
            }
        }
    }
}
</script>
@endsection