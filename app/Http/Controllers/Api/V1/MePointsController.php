<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\PointsResource;
use App\Models\PointsTransaction;
use App\Services\PointsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MePointsController
{
    public function __invoke(Request $request, PointsService $pointsService): JsonResponse
    {
        $user = $request->user();

        $balance = $pointsService->balance($user);
        $transactions = PointsTransaction::where('user_id', $user->id)
            ->latest()
            ->limit(50)
            ->get();

        return (new PointsResource([
            'balance' => $balance,
            'transactions' => $transactions,
        ]))->additional(['meta' => null])->response();
    }
}
