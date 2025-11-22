<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryMissionResource extends JsonResource
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
			'status' => $this->status,
			'pickup_address' => $this->pickup_address,
			'dropoff_address' => $this->dropoff_address,
			'pickup_coords' => [
				'lat' => $this->pickup_lat,
				'lng' => $this->pickup_lng,
			],
			'dropoff_coords' => [
				'lat' => $this->dropoff_lat,
				'lng' => $this->dropoff_lng,
			],
			'created_at' => $this->created_at->toIso8601String(),
			'job_request' => new JobRequestResource($this->whenLoaded('jobRequest')),
			'driver' => new DriverProfileResource($this->whenLoaded('driver')),
		];
	}
}
