<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverProfileResource extends JsonResource
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
			'vehicle_type' => $this->vehicle_type,
			'license_plate' => $this->license_plate,
			'is_online' => $this->is_online,
			'current_lat' => $this->current_lat,
			'current_lng' => $this->current_lng,
			'user' => new UserResource($this->whenLoaded('user')),
		];
	}
}
