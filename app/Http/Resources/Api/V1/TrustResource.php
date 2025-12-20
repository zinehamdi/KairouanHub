<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TrustResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'trust_level' => $this->resource['trust_level'] ?? null,
            'score' => $this->resource['score'] ?? 0,
            'limits' => [
                'submissions_per_hour' => $this->resource['submissions_per_hour'] ?? 0,
            ],
            'last_promoted_at' => $this->resource['last_promoted_at'] ?? null,
        ];
    }
}
