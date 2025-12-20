<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\JobRequestResource;
use App\Services\JobRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobRequestBrowseController
{
    public function index(Request $request, JobRequestService $service): JsonResponse
    {
        $jobs = $service->listOpen($request->user(), $request->only(['city', 'category_id', 'service_id']), 12);

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

    public function show(int $id, JobRequestService $service): JsonResponse
    {
        $job = $service->findForUser(auth()->user(), $id);

        return (new JobRequestResource($job))
            ->additional(['meta' => null])
            ->response();
    }
}
