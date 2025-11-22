<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ProviderProfileResource;
use App\Models\Service;
use App\Models\ProviderProfile;
use App\Models\JobRequest;
use App\Models\User;

class HomeController extends BaseApiController
{
	/**
	 * Get homepage data.
	 */
	public function index()
	{
		// Featured services (top 6 by provider count)
		$featuredServices = Service::where('is_active', true)
			->withCount('providers')
			->orderBy('providers_count', 'desc')
			->limit(6)
			->get();

		// Top providers (by rating)
		$topProviders = ProviderProfile::where('status', 'approved')
			->orderBy('avg_rating', 'desc')
			->limit(6)
			->with('user')
			->get();

		// Statistics
		$stats = [
			'total_services' => Service::where('is_active', true)->count(),
			'total_providers' => ProviderProfile::where('status', 'approved')->count(),
			'total_requests' => JobRequest::count(),
			'total_users' => User::count(),
		];

		return $this->successResponse([
			'featured_services' => ServiceResource::collection($featuredServices),
			'top_providers' => ProviderProfileResource::collection($topProviders),
			'statistics' => $stats,
		]);
	}
}
