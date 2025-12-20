<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreJobRequestApiRequest;
use App\Http\Resources\JobRequestResource;
use App\Services\JobRequestService;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class JobRequestCreateController
{
    public function __invoke(StoreJobRequestApiRequest $request, JobRequestService $service): JsonResponse
    {
        try {
            $job = $service->create($request->validated(), $request->user());

            return (new JobRequestResource($job))
                ->additional(['meta' => null])
                ->response()
                ->setStatusCode(201);
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 400);
        }
    }
}
