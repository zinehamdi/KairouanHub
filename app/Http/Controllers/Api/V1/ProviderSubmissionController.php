<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ProviderSubmissionStoreRequest;
use App\Http\Resources\Api\V1\ProviderSubmissionResource;
use App\Services\ProviderSubmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ProviderSubmissionController
{
    public function index(Request $request, ProviderSubmissionService $service): JsonResponse
    {
        $submissions = $service->listMine($request->user());

        return ProviderSubmissionResource::collection($submissions)
            ->additional(['meta' => [
                'pagination' => [
                    'current_page' => $submissions->currentPage(),
                    'per_page' => $submissions->perPage(),
                    'total' => $submissions->total(),
                    'last_page' => $submissions->lastPage(),
                ],
            ]])
            ->response();
    }

    public function store(ProviderSubmissionStoreRequest $request, ProviderSubmissionService $service): JsonResponse
    {
        try {
            $submission = $service->create($request->validated(), $request->user());

            return (new ProviderSubmissionResource($submission))
                ->additional(['meta' => null])
                ->response();
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 422);
        }
    }
}
