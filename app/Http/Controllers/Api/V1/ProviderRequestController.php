<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\JobRequestResource;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class ProviderRequestController extends BaseApiController
{
	/**
	 * List requests assigned to me.
	 */
	public function index(Request $request)
	{
		$profile = $request->user()->providerProfile;

		if (!$profile) {
			return $this->errorResponse('Provider profile not found.', 404);
		}

		$requests = JobRequest::where('provider_id', $profile->id)
			->with(['client', 'category', 'service'])
			->latest()
			->paginate(10);

		return $this->successResponse(
			JobRequestResource::collection($requests)->response()->getData(true)
		);
	}

	/**
	 * Update request status (Accept, Reject, Complete).
	 */
	public function updateStatus(Request $request, $id)
	{
		$request->validate([
			'status' => 'required|in:matched,completed,cancelled', // matched = accepted
		]);

		$profile = $request->user()->providerProfile;

		if (!$profile) {
			return $this->errorResponse('Provider profile not found.', 404);
		}

		$jobRequest = JobRequest::where('provider_id', $profile->id)
			->findOrFail($id);

		// State transitions logic
		// open -> matched (accepted)
		// matched -> completed
		// matched -> cancelled (rejected)

		if ($request->status === 'matched' && $jobRequest->status !== 'open') {
			return $this->errorResponse('Can only accept open requests.', 400);
		}

		if ($request->status === 'completed' && $jobRequest->status !== 'matched') {
			return $this->errorResponse('Can only complete accepted requests.', 400);
		}

		$jobRequest->update(['status' => $request->status]);

		return $this->successResponse(null, 'Request status updated successfully.');
	}
}
