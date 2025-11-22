<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ProviderServiceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderServiceController extends BaseApiController
{
	/**
	 * List my services.
	 */
	public function index(Request $request)
	{
		$user = $request->user();
		$profile = $user->providerProfile;

		if (!$profile) {
			return $this->errorResponse('Provider profile not found.', 404);
		}

		$services = $profile->services()->with('category')->get();

		return $this->successResponse(ProviderServiceResource::collection($services));
	}

	/**
	 * Attach a service to my profile.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'service_id' => 'required|exists:services,id',
			'price_min' => 'nullable|numeric|min:0',
			'price_max' => 'nullable|numeric|gte:price_min',
		]);

		$user = $request->user();
		$profile = $user->providerProfile;

		if (!$profile) {
			return $this->errorResponse('Provider profile not found.', 404);
		}

		// Check if already attached
		if ($profile->services()->where('service_id', $request->service_id)->exists()) {
			return $this->errorResponse('Service already added to your profile.', 400);
		}

		$profile->services()->attach($request->service_id, [
			'price_min' => $request->price_min,
			'price_max' => $request->price_max,
		]);

		return $this->successResponse(null, 'Service added successfully.', 201);
	}

	/**
	 * Update a service in my profile (prices).
	 */
	public function update(Request $request, $serviceId)
	{
		$request->validate([
			'price_min' => 'nullable|numeric|min:0',
			'price_max' => 'nullable|numeric|gte:price_min',
		]);

		$user = $request->user();
		$profile = $user->providerProfile;

		if (!$profile) {
			return $this->errorResponse('Provider profile not found.', 404);
		}

		if (!$profile->services()->where('service_id', $serviceId)->exists()) {
			return $this->errorResponse('Service not found in your profile.', 404);
		}

		$profile->services()->updateExistingPivot($serviceId, [
			'price_min' => $request->price_min,
			'price_max' => $request->price_max,
		]);

		return $this->successResponse(null, 'Service updated successfully.');
	}

	/**
	 * Detach a service from my profile.
	 */
	public function destroy(Request $request, $serviceId)
	{
		$user = $request->user();
		$profile = $user->providerProfile;

		if (!$profile) {
			return $this->errorResponse('Provider profile not found.', 404);
		}

		if (!$profile->services()->where('service_id', $serviceId)->exists()) {
			return $this->errorResponse('Service not found in your profile.', 404);
		}

		$profile->services()->detach($serviceId);

		return $this->successResponse(null, 'Service removed successfully.');
	}
}
