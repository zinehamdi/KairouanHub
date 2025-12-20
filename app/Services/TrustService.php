<?php

namespace App\Services;

use App\Models\ProviderSubmission;
use App\Models\User;
use App\Models\UserTrust;
use Carbon\Carbon;

class TrustService
{
    private const LEVELS = [
        'new' => [
            'threshold' => 0,
            'submissions_per_hour' => 3,
        ],
        'contributor' => [
            'threshold' => 100,
            'submissions_per_hour' => 5,
        ],
        'trusted' => [
            'threshold' => 300,
            'submissions_per_hour' => 8,
        ],
        'ambassador' => [
            'threshold' => 800,
            'submissions_per_hour' => 10,
        ],
    ];

    public function getOrCreate(User $user): UserTrust
    {
        return UserTrust::firstOrCreate(
            ['user_id' => $user->id],
            ['trust_level' => 'new', 'score' => 0]
        );
    }

    public function adjustScore(User $user, int $delta): UserTrust
    {
        $trust = $this->getOrCreate($user);
        $trust->score = max(0, $trust->score + $delta);

        $newLevel = $this->calculateLevel($trust->score);
        if ($newLevel !== $trust->trust_level) {
            $trust->trust_level = $newLevel;
            $trust->last_promoted_at = Carbon::now();
        }

        $trust->save();
        return $trust;
    }

    public function canSubmit(User $user): bool
    {
        $trust = $this->getOrCreate($user);
        $limit = self::LEVELS[$trust->trust_level]['submissions_per_hour'] ?? 3;

        $recentCount = ProviderSubmission::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subHour())
            ->count();

        return $recentCount < $limit;
    }

    public function submissionLimit(User $user): int
    {
        $trust = $this->getOrCreate($user);
        return self::LEVELS[$trust->trust_level]['submissions_per_hour'] ?? 3;
    }

    public function levelForScore(int $score): string
    {
        return $this->calculateLevel($score);
    }

    private function calculateLevel(int $score): string
    {
        // Check from highest to lowest
        foreach (array_reverse(self::LEVELS, true) as $level => $config) {
            if ($score >= $config['threshold']) {
                return $level;
            }
        }
        return 'new';
    }
}
