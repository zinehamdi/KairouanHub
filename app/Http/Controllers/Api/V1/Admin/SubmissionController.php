<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\Api\V1\Admin\RejectSubmissionRequest;
use App\Http\Resources\Api\V1\ProviderResource;
use App\Http\Resources\Api\V1\ProviderSubmissionResource;
use App\Models\ProviderSubmission;
use App\Services\ModerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class SubmissionController
{
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status', 'pending');

        $query = ProviderSubmission::query();
        if ($status) {
            $query->where('status', $status);
        }

        $submissions = $query->latest()->paginate(20);

        return response()->json([
            'data' => ProviderSubmissionResource::collection($submissions->items())->resolve(),
            'meta' => [
                'pagination' => [
                    'current_page' => $submissions->currentPage(),
                    'per_page' => $submissions->perPage(),
                    'total' => $submissions->total(),
                    'last_page' => $submissions->lastPage(),
                ],
            ],
        ]);
    }

    public function approve(ProviderSubmission $submission, ModerationService $moderationService): JsonResponse
    {
        try {
            $profile = $moderationService->approve($submission, auth()->user());

            return (new ProviderResource($profile))
                ->additional(['meta' => null])
                ->response()
                ->setStatusCode(201);
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 422);
        }
    }

    public function reject(RejectSubmissionRequest $request, ProviderSubmission $submission, ModerationService $moderationService): JsonResponse
    {
        try {
            $updated = $moderationService->reject($submission, auth()->user(), $request->validated()['reason']);

            return (new ProviderSubmissionResource($updated))
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
