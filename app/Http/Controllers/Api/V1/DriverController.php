<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\DriverProfileResource;
use App\Models\DriverProfile;
use Illuminate\Http\Request;

class DriverController extends BaseApiController
{
	/**
	 * Get or Create Driver Profile.
	 */
	public function profile(Request $request)
	{
		$user = $request->user();

		$profile = DriverProfile::firstOrCreate(
			['user_id' => $user->id],
			['vehicle_type' => 'car', 'is_online' => false]
		);

		return $this->successResponse(new DriverProfileResource($profile->load('user')));
	}

	/**
	 * Update Driver Profile.
	 */
	public function updateProfile(Request $request)
	{
		$request->validate([
			'vehicle_type' => 'required|in:car,bike,truck,scooter',
			'license_plate' => 'nullable|string',
		]);

		$user = $request->user();
		$profile = $user->driverProfile()->firstOrCreate(['user_id' => $user->id]);

		$profile->update($request->only(['vehicle_type', 'license_plate']));

		return $this->successResponse(new DriverProfileResource($profile), 'Profile updated successfully.');
	}

	/**
	 * Toggle Online Status.
	 */
	public function toggleStatus(Request $request)
	{
		$request->validate(['is_online' => 'required|boolean']);

		$user = $request->user();
		$profile = $user->driverProfile;

		if (!$profile) {
			return $this->errorResponse('Driver profile not found.', 404);
		}

		$profile->update(['is_online' => $request->is_online]);

		return $this->successResponse(['is_online' => $profile->is_online], 'Status updated.');
	}

	/**
	 * Update Location.
	 */
	public function updateLocation(Request $request)
	{
		$request->validate([
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
		]);

		$user = $request->user();
		$profile = $user->driverProfile;

		if (!$profile) {
			return $this->errorResponse('Driver profile not found.', 404);
		}

		$profile->update([
			'current_lat' => $request->lat,
			'current_lng' => $request->lng,
		]);

		return $this->successResponse(null, 'Location updated.');
	}
}
