<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProviderProfile;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Categories with service counts for horizontal scroll
        $categories = Category::where('is_active', true)
            ->orderBy('position')
            ->withCount('services')
            ->take(12)
            ->get();

        // Featured providers (top rated, approved)
        $featuredProviders = ProviderProfile::where('status', 'approved')
            ->orderByDesc('avg_rating')
            ->orderByDesc('completed_jobs')
            ->with('category')
            ->take(6)
            ->get();

        // Recent requests for community feed (show recent open requests)
        $recentRequests = JobRequest::where('status', 'open')
            ->with(['user', 'service', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact('categories', 'featuredProviders', 'recentRequests'));
    }

    public function healthz()
    {
        return response()->json(['status' => 'ok']);
    }
}

