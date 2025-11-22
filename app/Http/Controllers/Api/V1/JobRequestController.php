<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\JobRequestResource;
use App\Models\JobRequest;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;

class JobRequestController extends BaseApiController
{
	/**
	 * List my requests.
	 */
	public function index(Request $request)
	{
		$requests = JobRequest::where('client_id', $request->user()->id)
			->with(['category', 'service', 'provider'])
			->latest()
			->paginate(10);

		return $this->successResponse(
			JobRequestResource::collection($requests)->response()->getData(true)
		);
	}

	/**
	 * Create a new request (optionally direct to a provider).
	 */
	public function store(Request $request)
	{
		$request->validate([
			'category_id' => 'required|exists:categories,id',
			'service_id' => 'nullable|exists:services,id',
			'provider_id' => 'nullable|exists:provider_profiles,id',
			'details' => 'required|string|min:10',
			'city' => 'required|string',
			'scheduled_date' => 'nullable|date|after:now',
		]);

		// If provider is selected, ensure they offer the service (optional check, but good for data integrity)
		if ($request->provider_id && $request->service_id) {
			$provider = ProviderProfile::find($request->provider_id);
			if (!$provider->services()->where('service_id', $request->service_id)->exists()) {
				return $this->errorResponse('Selected provider does not offer this service.', 400);
			}
		}

		$jobRequest = JobRequest::create([
			'client_id' => $request->user()->id,
			'category_id' => $request->category_id,
			'service_id' => $request->service_id,
			'provider_id' => $request->provider_id,
			'details' => $request->details,
			'city' => $request->city,
			'scheduled_date' => $request->scheduled_date,
			'status' => 'open', // Default status
		]);

		return $this->successResponse(new JobRequestResource($jobRequest), 'Request created successfully.', 201);
	}

	/**
	 * Show request details.
	 */
	public function show(Request $request, $id)
	{
		$jobRequest = JobRequest::where('client_id', $request->user()->id)
			->with(['category', 'service', 'provider'])
			->findOrFail($id);

		return $this->successResponse(new JobRequestResource($jobRequest));
	}

	/**
	 * Cancel a request.
	 */
	public function cancel(Request $request, $id)
	{
		$jobRequest = JobRequest::where('client_id', $request->user()->id)
			->findOrFail($id);

		if (!in_array($jobRequest->status, ['open', 'matched'])) {
			return $this->errorResponse('Cannot cancel request in current status.', 400);
		}

		$jobRequest->update(['status' => 'cancelled']);

		return $this->successResponse(null, 'Request cancelled successfully.');
	}
}
