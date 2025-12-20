<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\TrustResource;
use App\Services\TrustService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeTrustController
{
    public function __invoke(Request $request, TrustService $trustService): JsonResponse
    {
        $user = $request->user();
        $trust = $trustService->getOrCreate($user);
        $submissionLimit = $trustService->submissionLimit($user);

        return (new TrustResource([
            'trust_level' => $trust->trust_level,
            'score' => $trust->score,
            'submissions_per_hour' => $submissionLimit,
            'last_promoted_at' => optional($trust->last_promoted_at)->toIso8601String(),
        ]))->additional(['meta' => null])->response();
    }
}
