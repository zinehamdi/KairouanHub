<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'request_id' => $this->request_id,
            'provider_id' => $this->provider_id,
            'note' => $this->note,
            'eta_days' => $this->eta_days,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
            'request' => new JobRequestResource($this->whenLoaded('request')),
        ];
    }
}
