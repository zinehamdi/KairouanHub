<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\ProviderSubmission;
use App\Services\PointsService;
use App\Services\TrustService;
use Illuminate\Http\Request;

/**
 * Rewards Controller - Immediate Feedback
 * 
 * Celebration animations, points earned, trust progression
 * Social, fun, rewarding
 */
class RewardsController extends BaseApiController
{
    /**
     * Get reward feedback for a submission
     * 
     * Called after suggestion is approved
     * Shows points earned, trust level up, next milestone
     */
    public function show(Request $request, $submissionId)
    {
        $user = $request->user();
        
        $submission = ProviderSubmission::where('user_id', $user->id)
            ->findOrFail($submissionId);

        $pointsService = app(PointsService::class);
        $trustService = app(TrustService::class);
        
        $trust = $trustService->getOrCreate($user);
        $pointsBalance = $pointsService->balance($user);

        // Calculate points earned from this submission
        $pointsEarned = 0;
        if ($submission->status === 'approved') {
            $pointsEarned = 50; // Standard reward
        }

        // Calculate next milestone
        $nextMilestone = $this->getNextMilestone($trust->score);

        return $this->successResponse([
            'submission' => [
                'id' => $submission->id,
                'status' => $submission->status,
                'provider_name' => $submission->provider_name,
            ],
            'rewards' => [
                'points_earned' => $pointsEarned,
                'points_balance' => $pointsBalance,
                'trust_level' => $trust->trust_level,
                'trust_score' => $trust->score,
                'next_milestone' => $nextMilestone,
            ],
            'celebration' => [
                'show_animation' => $submission->status === 'approved',
                'message' => $submission->status === 'approved' 
                    ? "مبارك! ربحت {$pointsEarned} نقطة!" 
                    : "اقتراحك رانا نتحققوا منه.",
            ],
        ]);
    }

    /**
     * Get user's current progress
     * 
     * For progress indicators, motivation without pressure
     */
    public function progress(Request $request)
    {
        $user = $request->user();
        
        $pointsService = app(PointsService::class);
        $trustService = app(TrustService::class);
        
        $trust = $trustService->getOrCreate($user);
        $pointsBalance = $pointsService->balance($user);
        
        $nextMilestone = $this->getNextMilestone($trust->score);
        
        // Calculate progress percentage to next milestone
        $progressPercent = 0;
        if ($nextMilestone) {
            $currentLevel = $this->getCurrentLevelThreshold($trust->score);
            $nextLevel = $nextMilestone['points_needed'] + $trust->score;
            $range = $nextLevel - $currentLevel;
            $progress = $trust->score - $currentLevel;
            $progressPercent = $range > 0 ? round(($progress / $range) * 100) : 0;
        }

        return $this->successResponse([
            'points' => [
                'balance' => $pointsBalance,
                'total_earned' => $pointsService->totalEarned($user) ?? 0,
            ],
            'trust' => [
                'level' => $trust->trust_level,
                'score' => $trust->score,
                'progress_percent' => $progressPercent,
                'next_milestone' => $nextMilestone,
            ],
            'stats' => [
                'suggestions_submitted' => $user->providerSubmissions()->count(),
                'suggestions_approved' => $user->providerSubmissions()->where('status', 'approved')->count(),
            ],
        ]);
    }

    /**
     * Get next trust milestone
     */
    private function getNextMilestone(int $currentScore): ?array
    {
        $milestones = [
            100 => 'contributor',
            300 => 'trusted',
            800 => 'ambassador',
        ];

        foreach ($milestones as $score => $level) {
            if ($currentScore < $score) {
                return [
                    'level' => $level,
                    'points_needed' => $score - $currentScore,
                    'threshold' => $score,
                ];
            }
        }

        return null; // Max level reached
    }

    /**
     * Get current level threshold
     */
    private function getCurrentLevelThreshold(int $score): int
    {
        $milestones = [0, 100, 300, 800];
        
        foreach (array_reverse($milestones) as $threshold) {
            if ($score >= $threshold) {
                return $threshold;
            }
        }
        
        return 0;
    }
}

