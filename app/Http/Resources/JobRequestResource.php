<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobRequestResource extends JsonResource
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
			'details' => $this->details,
			'city' => $this->city,
			'status' => $this->status,
			'scheduled_date' => $this->scheduled_date, // Will be added in migration
			'photos_json' => $this->photos_json,
			'created_at' => $this->created_at->toIso8601String(),
			'client' => new UserResource($this->whenLoaded('client')),
			'provider' => new ProviderProfileResource($this->whenLoaded('provider')),
			'category' => new CategoryResource($this->whenLoaded('category')),
			'service' => new ServiceResource($this->whenLoaded('service')),
		];
	}
}
