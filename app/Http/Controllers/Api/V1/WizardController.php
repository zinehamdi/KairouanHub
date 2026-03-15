<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Category;
use App\Models\Service;
use App\Models\ProviderProfile;
use App\Http\Resources\Api\V1\Wizard\CategoryCardResource;
use App\Http\Resources\Api\V1\Wizard\ServiceFeedResource;
use App\Http\Resources\Api\V1\Wizard\ProviderCardResource;
use Illuminate\Http\Request;

/**
 * Wizard Controller - Social, Feed-Like Navigation
 * 
 * Designed for Instagram/Facebook-style scrolling experience
 * One decision per screen, instant rewards, minimal thinking
 */
class WizardController extends BaseApiController
{
    /**
     * Wizard Start - Home Screen Bundle
     * 
     * Pre-aggregated data for instant loading
     * Includes categories, featured providers, user stats
     */
    public function start(Request $request)
    {
        $user = $request->user();
        
        // Categories with service counts (for gradient cards)
        $categories = Category::where('is_active', true)
            ->orderBy('position')
            ->withCount('services')
            ->get();

        // Featured providers (top 6 by trust/rating)
        $featuredProviders = ProviderProfile::approved()
            ->orderByDesc('avg_rating')
            ->orderByDesc('completed_jobs')
            ->limit(6)
            ->get();

        // User stats (if authenticated)
        $userStats = null;
        if ($user) {
            $userStats = [
                'points' => $user->points()->sum('points') ?? 0,
                'trust_level' => $user->trustScore ?? 0,
                'suggestions_pending' => $user->providerSubmissions()
                    ->where('status', 'pending')
                    ->count(),
            ];
        }

        return $this->successResponse([
            'categories' => CategoryCardResource::collection($categories),
            'featured_providers' => ProviderCardResource::collection($featuredProviders),
            'user_stats' => $userStats,
        ]);
    }

    /**
     * Step 1: Categories
     * 
     * Big gradient cards - minimal data, visual-first
     */
    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('position')
            ->withCount('services')
            ->get();

        return $this->successResponse(
            CategoryCardResource::collection($categories)
        );
    }

    /**
     * Step 2: Services Feed
     * 
     * Infinite scroll - Instagram-like feed
     * Optimized pagination for smooth scrolling
     */
    public function services(Request $request)
    {
        $query = Service::where('is_active', true)
            ->withCount('providers');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Cursor-based pagination for infinite scroll
        $limit = $request->get('limit', 20);
        $cursor = $request->get('cursor');

        if ($cursor) {
            $query->where('id', '>', $cursor);
        }

        $services = $query->orderBy('id')
            ->limit($limit + 1) // Fetch one extra to check if more exists
            ->get();

        $hasMore = $services->count() > $limit;
        if ($hasMore) {
            $services->pop(); // Remove the extra item
        }

        $nextCursor = $hasMore ? $services->last()->id : null;

        return $this->successResponse([
            'data' => ServiceFeedResource::collection($services),
            'pagination' => [
                'next_cursor' => $nextCursor,
                'has_more' => $hasMore,
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Step 3: Providers Feed
     * 
     * Provider cards with trust badges
     * Social feed style with recommendation levels
     */
    public function providers(Request $request)
    {
        $query = ProviderProfile::approved()
            ->with(['category']); // Only load category name, not full object

        // Filter by service
        if ($request->has('service_id')) {
            $query->withService($request->service_id);
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by city
        if ($request->has('city')) {
            $query->city($request->city);
        }

        // Sort by trust/recommendation level
        $query->orderByDesc('avg_rating')
            ->orderByDesc('completed_jobs');

        // Cursor-based pagination
        $limit = $request->get('limit', 20);
        $cursor = $request->get('cursor');

        if ($cursor) {
            $query->where('id', '>', $cursor);
        }

        $providers = $query->orderBy('id')
            ->limit($limit + 1)
            ->get();

        $hasMore = $providers->count() > $limit;
        if ($hasMore) {
            $providers->pop();
        }

        $nextCursor = $hasMore ? $providers->last()->id : null;

        return $this->successResponse([
            'data' => ProviderCardResource::collection($providers),
            'pagination' => [
                'next_cursor' => $nextCursor,
                'has_more' => $hasMore,
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Step 4: Suggest Provider
     * 
     * Quick 1-2 tap form submission
     * Immediate reward feedback
     */
    public function suggest(Request $request)
    {
        $validated = $request->validate([
            'provider_name' => 'required|string|max:255',
            'phone' => 'required|string|max:32',
            'category_id' => 'nullable|exists:categories,id',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $submissionService = app(\App\Services\ProviderSubmissionService::class);
            $submission = $submissionService->create($validated, $request->user());

            // Calculate trust level for immediate feedback
            $trustService = app(\App\Services\TrustService::class);
            $trust = $trustService->getOrCreate($request->user());

            return $this->successResponse([
                'submission' => [
                    'id' => $submission->id,
                    'status' => $submission->status,
                    'provider_name' => $submission->provider_name,
                ],
                'feedback' => [
                    'message' => 'شكراً! اقتراحك رانا نتحققوا منه.',
                    'points_potential' => 50, // Points if approved
                    'points_message' => 'إذا تم قبوله، ربحت 50 نقطة.',
                    'trust_level' => $trust->trust_level ?? 'new',
                    'trust_score' => $trust->score ?? 0,
                    'next_milestone' => $this->getNextMilestone($trust->score ?? 0),
                ],
            ], 'تم إرسال الاقتراح بنجاح', 201);

        } catch (\RuntimeException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Get next trust milestone
     */
    private function getNextMilestone(int $currentScore): ?array
    {
        $milestones = [
            100 => 'Silver',
            500 => 'Gold',
            1000 => 'Platinum',
        ];

        foreach ($milestones as $score => $level) {
            if ($currentScore < $score) {
                return [
                    'level' => $level,
                    'points_needed' => $score - $currentScore,
                ];
            }
        }

        return null; // Max level reached
    }
}

