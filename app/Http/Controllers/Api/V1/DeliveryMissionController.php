<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\DeliveryMissionResource;
use App\Models\DeliveryMission;
use Illuminate\Http\Request;

class DeliveryMissionController extends BaseApiController
{
	/**
	 * List available missions (pending).
	 */
	public function index(Request $request)
	{
		// In a real app, filter by proximity to driver
		$missions = DeliveryMission::where('status', 'pending')
			->with('jobRequest')
			->latest()
			->paginate(10);

		return $this->successResponse(
			DeliveryMissionResource::collection($missions)->response()->getData(true)
		);
	}

	/**
	 * List my assigned missions.
	 */
	public function myMissions(Request $request)
	{
		$profile = $request->user()->driverProfile;

		if (!$profile) {
			return $this->errorResponse('Driver profile not found.', 404);
		}

		$missions = DeliveryMission::where('driver_id', $profile->id)
			->with('jobRequest')
			->latest()
			->paginate(10);

		return $this->successResponse(
			DeliveryMissionResource::collection($missions)->response()->getData(true)
		);
	}

	/**
	 * Accept a mission.
	 */
	public function accept(Request $request, $id)
	{
		$profile = $request->user()->driverProfile;

		if (!$profile) {
			return $this->errorResponse('Driver profile not found.', 404);
		}

		$mission = DeliveryMission::where('status', 'pending')->findOrFail($id);

		$mission->update([
			'driver_id' => $profile->id,
			'status' => 'accepted',
		]);

		return $this->successResponse(new DeliveryMissionResource($mission), 'Mission accepted.');
	}

	/**
	 * Update mission status.
	 */
	public function updateStatus(Request $request, $id)
	{
		$request->validate([
			'status' => 'required|in:picked_up,delivered,cancelled',
		]);

		$profile = $request->user()->driverProfile;

		if (!$profile) {
			return $this->errorResponse('Driver profile not found.', 404);
		}

		$mission = DeliveryMission::where('driver_id', $profile->id)->findOrFail($id);

		$mission->update(['status' => $request->status]);

		return $this->successResponse(null, 'Mission status updated.');
	}
}
