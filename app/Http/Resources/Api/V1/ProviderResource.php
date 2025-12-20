<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'category_id' => $this->category_id,
            'display_name' => $this->display_name,
            'avatar' => $this->avatar,
            'bio' => $this->bio,
            'city' => $this->city,
            'cities' => $this->cities_json,
            'skills' => $this->skills_json,
            'photos' => $this->photos_json,
            'badge_level' => $this->badge_level,
            'status' => $this->status,
            'avg_rating' => $this->avg_rating,
            'completed_jobs' => $this->completed_jobs,
            'social' => $this->social_json,
            'website' => $this->website,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
