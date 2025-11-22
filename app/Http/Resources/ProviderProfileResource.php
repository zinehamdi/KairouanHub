<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderProfileResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'display_name' => $this->display_name,
			'bio' => $this->bio,
			'city' => $this->city,
			'cities_json' => $this->cities_json,
			'skills_json' => $this->skills_json,
			'photos_json' => $this->photos_json,
			'badge_level' => $this->badge_level,
			'status' => $this->status,
			'avg_rating' => $this->avg_rating,
			'completed_jobs' => $this->completed_jobs,
			'social_json' => $this->social_json,
			'website' => $this->website,
			'created_at' => $this->created_at->toIso8601String(),
			'user' => new UserResource($this->whenLoaded('user')),
			'category' => new CategoryResource($this->whenLoaded('category')),
			'services' => ProviderServiceResource::collection($this->whenLoaded('services')),
		];
	}
}
