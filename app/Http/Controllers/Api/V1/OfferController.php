<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\OfferResource;
use App\Infrastructure\Http\Requests\Jobs\StoreOfferRequest;
use App\Models\JobRequest;
use App\Models\Offer;
use App\Services\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class OfferController
{
    public function store(StoreOfferRequest $request, int $id, OfferService $service): JsonResponse
    {
        $job = JobRequest::findOrFail($id);

        try {
            $offer = $service->create($job, $request->user(), $request->validated());

            return (new OfferResource($offer))
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

    public function myOffers(Request $request): JsonResponse
    {
        $profile = $request->user()->providerProfile;
        if (!$profile) {
            return response()->json([
                'message' => 'Provider profile required',
                'errors' => [],
            ], 403);
        }

        $offers = Offer::with('request')
            ->where('provider_id', $profile->id)
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => OfferResource::collection($offers->items())->resolve(),
            'meta' => [
                'pagination' => [
                    'current_page' => $offers->currentPage(),
                    'per_page' => $offers->perPage(),
                    'total' => $offers->total(),
                    'last_page' => $offers->lastPage(),
                ],
            ],
        ]);
    }

    public function accept(int $id, OfferService $service): JsonResponse
    {
        $offer = Offer::with(['request', 'provider'])->findOrFail($id);

        try {
            $accepted = $service->accept($offer, auth()->user());

            return (new OfferResource($accepted))
                ->additional(['meta' => null])
                ->response();
        } catch (RuntimeException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => [],
            ], 400);
        }
    }
}
