<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProviderProfile;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = ProviderProfile::with(['user', 'services'])
            ->latest()
            ->paginate(20);

        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        $services = Service::with('category')->get()->groupBy('category.name');
        return view('admin.providers.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(),
            ]);

            // Assign provider role
            $user->assignRole('provider');

            // Create provider profile
            $profile = ProviderProfile::create([
                'user_id' => $user->id,
                'phone' => $validated['phone'],
                'bio' => $validated['bio'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? 'Kairouan',
                'is_approved' => true,
                'approved_at' => now(),
            ]);

            // Attach services
            $serviceData = [];
            foreach ($validated['services'] as $serviceId) {
                $serviceData[$serviceId] = [
                    'price_min' => $request->input("price_min.{$serviceId}", 50),
                    'price_max' => $request->input("price_max.{$serviceId}", 200),
                ];
            }
            $profile->services()->attach($serviceData);

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create provider: ' . $e->getMessage());
        }
    }

    public function show(ProviderProfile $provider)
    {
        $provider->load(['user', 'services.category']);
        return view('admin.providers.show', compact('provider'));
    }

    public function edit(ProviderProfile $provider)
    {
        $services = Service::with('category')->get()->groupBy('category.name');
        $provider->load(['user', 'services']);
        return view('admin.providers.edit', compact('provider', 'services'));
    }

    public function update(Request $request, ProviderProfile $provider)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $provider->user_id,
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'is_approved' => 'boolean',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $provider->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $request->validate(['password' => 'string|min:8|confirmed']);
                $provider->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Update provider profile
            $provider->update([
                'phone' => $validated['phone'],
                'bio' => $validated['bio'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? 'Kairouan',
                'is_approved' => $validated['is_approved'] ?? $provider->is_approved,
                'approved_at' => $validated['is_approved'] && !$provider->is_approved ? now() : $provider->approved_at,
            ]);

            // Sync services
            $serviceData = [];
            foreach ($validated['services'] as $serviceId) {
                $serviceData[$serviceId] = [
                    'price_min' => $request->input("price_min.{$serviceId}", 50),
                    'price_max' => $request->input("price_max.{$serviceId}", 200),
                ];
            }
            $provider->services()->sync($serviceData);

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update provider: ' . $e->getMessage());
        }
    }

    public function destroy(ProviderProfile $provider)
    {
        DB::beginTransaction();
        try {
            $user = $provider->user;
            $provider->services()->detach();
            $provider->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('admin.providers.index')
                ->with('success', 'Provider deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete provider: ' . $e->getMessage());
        }
    }

    public function approve(ProviderProfile $provider)
    {
        $provider->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Provider approved successfully!');
    }

    public function reject(ProviderProfile $provider)
    {
        $provider->update([
            'is_approved' => false,
            'approved_at' => null,
        ]);

        return back()->with('success', 'Provider rejected successfully!');
    }

    /**
     * Show the map import interface.
     * This is an optional feature - dashboard works without it.
     */
    public function mapImport()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        
        return view('admin.providers.map-import', compact('categories'));
    }

    /**
     * Search for places from the map (AJAX).
     * Returns preview data only - nothing is saved.
     */
    public function searchFromMap(Request $request)
    {
        try {
            $placesService = app(\App\Services\GooglePlacesService::class);
            
            $query = $request->input('query');
            $lat = $request->input('lat', 35.6781); // Kairouan default
            $lng = $request->input('lng', 10.0963);
            $radius = $request->input('radius', 5000);

            if ($query) {
                // Text search
                $results = $placesService->searchPlaces($query, [
                    'location' => "{$lat},{$lng}",
                    'radius' => $radius,
                ]);
            } else {
                // Nearby search (when clicking on map)
                $results = $placesService->searchPlaces('*', [
                    'location' => "{$lat},{$lng}",
                    'radius' => $radius,
                ]);
            }

            return response()->json([
                'success' => true,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            \Log::error('Map search error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => __('admin.search_error', ['default' => 'Unable to search. Please try again.']),
            ], 200); // Return 200 to handle gracefully in frontend
        }
    }

    /**
     * Confirm and create provider from reviewed data.
     * This is the only place where data is actually saved.
     */
    public function confirmImport(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'rating' => 'nullable|numeric|min:0|max:5',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'place_id' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Generate a unique email for the imported provider
            $slug = \Str::slug($validated['name']);
            $uniqueId = \Str::random(6);
            $email = "imported.{$slug}.{$uniqueId}@kairouanhub.local";

            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'password' => Hash::make(\Str::random(16)), // Random password
                'email_verified_at' => now(),
            ]);

            // Assign provider role
            $user->assignRole('provider');

            // Store Google data as metadata
            $socialJson = [];
            if ($validated['lat'] && $validated['lng']) {
                $socialJson['coordinates'] = [
                    'lat' => $validated['lat'],
                    'lng' => $validated['lng'],
                ];
            }
            if ($validated['place_id'] ?? null) {
                $socialJson['google_place_id'] = $validated['place_id'];
            }

            // Create provider profile
            $profile = ProviderProfile::create([
                'user_id' => $user->id,
                'display_name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'city' => $validated['city'] ?? 'Kairouan',
                'category_id' => $validated['category_id'] ?? null,
                'website' => $validated['website'] ?? null,
                'avg_rating' => $validated['rating'] ?? null,
                'social_json' => !empty($socialJson) ? $socialJson : null,
                'status' => 'approved', // Auto-approve imported providers
                'bio' => __('admin.imported_from_google', ['default' => 'Imported from Google Maps']),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('admin.provider_imported', ['name' => $validated['name'], 'default' => "Provider '{$validated['name']}' imported successfully!"]),
                'provider_id' => $profile->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Import error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('admin.import_failed', ['default' => 'Failed to import provider. Please try again.']),
            ], 200);
        }
    }
}
