<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\ProviderProfile;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index()
	{
		$stats = [
			'total_users' => User::count(),
			'total_providers' => ProviderProfile::count(),
			'total_services' => Service::count(),
			'total_categories' => Category::count(),
			'total_requests' => JobRequest::count(),
			'pending_requests' => JobRequest::where('status', 'pending')->count(),
			'recent_users' => User::latest()->take(5)->get(),
			'recent_providers' => ProviderProfile::with('user')->latest()->take(5)->get(),
			'recent_requests' => JobRequest::with(['user', 'service'])->latest()->take(10)->get(),
		];

		return view('admin.dashboard', $stats);
	}
}
