<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\JobRequestResource;
use App\Services\JobRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MyJobRequestsController
{
    public function __invoke(Request $request, JobRequestService $service): JsonResponse
    {
        $jobs = $service->listMine($request->user());

        return response()->json([
            'data' => JobRequestResource::collection($jobs->items())->resolve(),
            'meta' => [
                'pagination' => [
                    'current_page' => $jobs->currentPage(),
                    'per_page' => $jobs->perPage(),
                    'total' => $jobs->total(),
                    'last_page' => $jobs->lastPage(),
                ],
            ],
        ]);
    }
}
