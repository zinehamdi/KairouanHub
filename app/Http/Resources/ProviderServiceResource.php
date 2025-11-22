<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderServiceResource extends JsonResource
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
			'name' => $this->name,
			'slug' => $this->slug,
			'summary' => $this->summary,
			'category' => new CategoryResource($this->whenLoaded('category')),
			'price_min' => $this->pivot->price_min ?? null,
			'price_max' => $this->pivot->price_max ?? null,
		];
	}
}
