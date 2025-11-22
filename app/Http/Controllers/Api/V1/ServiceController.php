<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends BaseApiController
{
	/**
	 * List services with filtering and pagination.
	 */
	public function index(Request $request)
	{
		$query = Service::where('is_active', true)
			->with(['category'])
			->withCount('providers');

		// Filter by Category
		if ($request->has('category_id')) {
			$query->where('category_id', $request->category_id);
		}

		// Search by Name
		if ($request->has('search')) {
			$search = $request->search;
			$query->where(function ($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
					->orWhere('summary', 'like', "%{$search}%");
			});
		}

		$services = $query->paginate(20);

		return $this->successResponse(
			ServiceResource::collection($services)->response()->getData(true)
		);
	}

	/**
	 * Show a specific service.
	 */
	public function show($id)
	{
		$service = Service::where('is_active', true)
			->with(['category'])
			->withCount('providers')
			->findOrFail($id);

		return $this->successResponse(new ServiceResource($service));
	}
}
