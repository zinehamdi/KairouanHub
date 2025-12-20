<?php

namespace App\Services;

use App\Models\PointsTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PointsService
{
    public function award(User $user, int $points, string $reason, ?Model $related = null, array $meta = []): PointsTransaction
    {
        return DB::transaction(function () use ($user, $points, $reason, $related, $meta) {
            return PointsTransaction::create([
                'user_id' => $user->id,
                'type' => 'earn',
                'points' => $points,
                'reason' => $reason,
                'related_type' => $related?->getMorphClass(),
                'related_id' => $related?->getKey(),
                'meta' => $meta,
            ]);
        });
    }

    public function spend(User $user, int $points, string $reason, ?Model $related = null, array $meta = []): PointsTransaction
    {
        return DB::transaction(function () use ($user, $points, $reason, $related, $meta) {
            return PointsTransaction::create([
                'user_id' => $user->id,
                'type' => 'spend',
                'points' => $points,
                'reason' => $reason,
                'related_type' => $related?->getMorphClass(),
                'related_id' => $related?->getKey(),
                'meta' => $meta,
            ]);
        });
    }

    public function balance(User $user): int
    {
        $earn = PointsTransaction::where('user_id', $user->id)->where('type', 'earn')->sum('points');
        $spend = PointsTransaction::where('user_id', $user->id)->where('type', 'spend')->sum('points');
        return $earn - $spend;
    }
}
