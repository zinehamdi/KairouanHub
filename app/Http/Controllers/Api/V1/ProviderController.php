<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ProviderProfileResource;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;

class ProviderController extends BaseApiController
{
	/**
	 * List providers with filtering.
	 */
	public function index(Request $request)
	{
		$query = ProviderProfile::approved()
			->with(['user', 'category', 'services']);

		// Filter by Category
		if ($request->has('category_id')) {
			$query->where('category_id', $request->category_id);
		}

		// Filter by Service
		if ($request->has('service_id')) {
			$query->withService($request->service_id);
		}

		// Filter by City
		if ($request->has('city')) {
			$query->city($request->city);
		}

		// Search by Name/Bio
		if ($request->has('search')) {
			$query->search($request->search);
		}

		$providers = $query->paginate(15);

		return $this->successResponse(
			ProviderProfileResource::collection($providers)->response()->getData(true)
		);
	}

	/**
	 * Show a specific provider.
	 */
	public function show($id)
	{
		$provider = ProviderProfile::approved()
			->with(['user', 'category', 'services'])
			->findOrFail($id);

		return $this->successResponse(new ProviderProfileResource($provider));
	}
}
