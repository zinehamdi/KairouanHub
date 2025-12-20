<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class JobRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'details' => $this->details,
            'city' => $this->city,
            'status' => $this->status,
            'scheduled_date' => $this->scheduled_date,
            'photos_json' => $this->photos_json,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'client_id' => $this->client_id,
            'provider_id' => $this->provider_id,
            'category_id' => $this->category_id,
            'service_id' => $this->service_id,
        ];
    }
}
