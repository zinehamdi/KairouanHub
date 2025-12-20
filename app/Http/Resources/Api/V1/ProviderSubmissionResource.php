<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderSubmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'provider_name' => $this->provider_name,
            'phone' => $this->phone,
            'category_id' => $this->category_id,
            'city' => $this->city,
            'description' => $this->description,
            'status' => $this->status,
            'reviewed_by' => $this->reviewed_by,
            'reviewed_at' => optional($this->reviewed_at)->toIso8601String(),
            'rejection_reason' => $this->rejection_reason,
            'meta' => $this->meta,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
