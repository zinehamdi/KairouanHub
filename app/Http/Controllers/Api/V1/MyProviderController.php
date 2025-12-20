<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UpdateProviderProfileRequest;
use App\Http\Resources\Api\V1\ProviderResource;
use App\Models\ProviderProfile;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class MyProviderController
{
    public function show(): JsonResponse
    {
        $profile = auth()->user()->providerProfile;
        if (!$profile) {
            return response()->json([
                'message' => 'Provider profile not found',
                'errors' => [],
            ], 404);
        }

        return (new ProviderResource($profile))
            ->additional(['meta' => null])
            ->response();
    }

    public function update(UpdateProviderProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $profile = $user->providerProfile ?? new ProviderProfile(['user_id' => $user->id, 'status' => 'pending', 'badge_level' => 'none']);

        $profile->fill($data);
        if (!$profile->exists) {
            $profile->user_id = $user->id;
        }

        try {
            $profile->save();
        } catch (\Throwable $e) {
            throw new RuntimeException('Unable to save provider profile: ' . $e->getMessage(), 0, $e);
        }

        return (new ProviderResource($profile->fresh()))
            ->additional(['meta' => null])
            ->response();
    }
}
