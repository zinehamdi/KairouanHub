<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\ProviderProfile;
use App\Models\JobRequest;
use App\Models\ProviderSubmission;
use App\Models\Settings;
use App\Services\GooglePlacesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
	/**
	 * Superadmin dashboard with advanced stats and management.
	 */
	public function superadmin()
	{
		$stats = [
			'total_admins' => User::role('admin')->count(),
			'total_users' => User::count(),
			'total_providers' => ProviderProfile::count(),
			'total_services' => Service::count(),
			'total_categories' => Category::count(),
			'total_requests' => JobRequest::count(),
			'admins' => User::role('admin')->get(),
			'recent_users' => User::latest()->take(5)->get(),
			'recent_providers' => ProviderProfile::with('user')->latest()->take(5)->get(),
			'recent_requests' => JobRequest::with(['user', 'service'])->latest()->take(10)->get(),
			'categories' => Category::all(),
			'settings' => Settings::allAsArray(),
		];
		return view('superadmin.dashboard', $stats);
	}

	/**
	 * Admin dashboard for regular admins.
	 */
	public function index()
	{
		$stats = [
			'total_users' => User::count(),
			'total_providers' => ProviderProfile::count(),
			'total_services' => Service::count(),
			'total_categories' => Category::count(),
			'total_requests' => JobRequest::count(),
			'pending_requests' => JobRequest::where('status', 'pending')->count(),
			'pending_submissions' => ProviderSubmission::where('status', 'pending')->count(),
			'recent_users' => User::latest()->take(5)->get(),
			'recent_providers' => ProviderProfile::with('user')->latest()->take(5)->get(),
			'recent_requests' => JobRequest::with(['user', 'service'])->latest()->take(10)->get(),
			'recent_submissions' => ProviderSubmission::with(['user', 'category'])->latest()->take(5)->get(),
		];

		return view('admin.dashboard', $stats);
	}

	/**
	 * Add a new admin user.
	 */
	public function addAdmin(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
		]);

		$user = User::create([
			'name' => $validated['name'],
			'email' => $validated['email'],
			'password' => Hash::make($validated['password']),
			'email_verified_at' => now(),
		]);

		$user->assignRole('admin');

		return redirect()->route('superadmin.dashboard')
			->with('success', 'Admin user created successfully.');
	}

	/**
	 * Remove admin role from a user.
	 */
	public function removeAdmin(User $user)
	{
		if ($user->hasRole('admin')) {
			$user->removeRole('admin');
			return redirect()->route('superadmin.dashboard')
				->with('success', 'Admin role removed successfully.');
		}

		return redirect()->route('superadmin.dashboard')
			->with('error', 'User does not have admin role.');
	}

	/**
	 * Update platform settings.
	 */
	public function updateSettings(Request $request)
	{
		$validated = $request->validate([
			'site_name' => 'sometimes|string|max:255',
			'site_email' => 'sometimes|email|max:255',
			'site_phone' => 'sometimes|string|max:255',
			'contact_address' => 'sometimes|string|max:500',
			'maintenance_mode' => 'sometimes|boolean',
		]);

		foreach ($validated as $key => $value) {
			$type = $key === 'maintenance_mode' ? 'boolean' : 'string';
			Settings::set($key, $value, $type);
		}

		return redirect()->route('superadmin.dashboard')
			->with('success', 'Platform settings updated successfully.');
	}

	/**
	 * Search Google Places for providers.
	 */
	public function googlePlacesSearch(Request $request, GooglePlacesService $placesService)
	{
		$validated = $request->validate([
			'query' => 'required|string|max:255',
		]);

		try {
			$results = $placesService->searchPlaces($validated['query']);
			
			return response()->json([
				'success' => true,
				'results' => $results,
			]);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}

	/**
	 * Import providers from Google Places.
	 */
	public function importProviders(Request $request, GooglePlacesService $placesService)
	{
		$validated = $request->validate([
			'place_ids' => 'required|array',
			'place_ids.*' => 'required|string',
			'category_id' => 'nullable|exists:categories,id',
		]);

		$imported = 0;
		$skipped = 0;
		$errors = [];

		DB::beginTransaction();
		try {
			foreach ($validated['place_ids'] as $placeId) {
				try {
					$details = $placesService->getPlaceDetails($placeId);
					
					if (!$details) {
						$errors[] = "Failed to fetch details for place ID: {$placeId}";
						$skipped++;
						continue;
					}

					// Check for duplicate by phone or name
					$phone = $details['phone'] ?? null;
					$name = $details['name'] ?? '';
					
					$existing = null;
					if ($phone) {
						$existing = ProviderProfile::where('phone', $phone)->first();
					}
					if (!$existing && $name) {
						$existing = ProviderProfile::where('display_name', $name)
							->where('city', 'Kairouan')
							->first();
					}

					if ($existing) {
						$skipped++;
						continue;
					}

					// Create user for the provider (with a temporary email if not provided)
					$email = 'provider_' . uniqid() . '@imported.local';
					
					// Check if email exists
					while (User::where('email', $email)->exists()) {
						$email = 'provider_' . uniqid() . '@imported.local';
					}

					$user = User::create([
						'name' => $name,
						'email' => $email,
						'password' => Hash::make(uniqid()), // Random password
						'email_verified_at' => now(),
					]);

					$user->assignRole('provider');

					// Extract city from address or default to Kairouan
					$city = 'Kairouan';
					$address = $details['address'] ?? '';
					if (stripos($address, 'Kairouan') !== false) {
						$city = 'Kairouan';
					}

					// Map Google types to category (simplified - you may want to improve this)
					$categoryId = $validated['category_id'] ?? null;
					if (!$categoryId) {
						// Try to match Google types to categories
						$types = $details['types'] ?? [];
						foreach ($types as $type) {
							$category = Category::where('name', 'like', "%{$type}%")
								->orWhere('name_ar', 'like', "%{$type}%")
								->first();
							if ($category) {
								$categoryId = $category->id;
								break;
							}
						}
					}

					// Create provider profile
					ProviderProfile::create([
						'user_id' => $user->id,
						'display_name' => $name,
						'phone' => $phone,
						'category_id' => $categoryId,
						'city' => $city,
						'bio' => $address,
						'website' => $details['website'] ?? null,
						'avg_rating' => $details['rating'] ?? null,
						'status' => 'approved', // Auto-approve imported providers
					]);

					$imported++;
				} catch (\Exception $e) {
					Log::error('Error importing provider', [
						'place_id' => $placeId,
						'error' => $e->getMessage(),
					]);
					$errors[] = "Error importing {$placeId}: {$e->getMessage()}";
					$skipped++;
				}
			}

			DB::commit();

			$message = "Successfully imported {$imported} provider(s).";
			if ($skipped > 0) {
				$message .= " {$skipped} skipped (duplicates or errors).";
			}

			return redirect()->route('superadmin.dashboard')
				->with('success', $message)
				->with('import_errors', $errors);

		} catch (\Exception $e) {
			DB::rollBack();
			Log::error('Error in importProviders', [
				'error' => $e->getMessage(),
			]);

			return redirect()->route('superadmin.dashboard')
				->with('error', 'Failed to import providers: ' . $e->getMessage());
		}
	}
}