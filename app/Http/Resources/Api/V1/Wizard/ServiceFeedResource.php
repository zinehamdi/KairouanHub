<?php

namespace App\Http\Resources\Api\V1\Wizard;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Service Feed Resource - For Instagram-Like Feed
 * 
 * Lightweight, scrollable, social-friendly
 * Optimized for infinite scroll
 */
class ServiceFeedResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ar' => $this->name_ar ?? null,
            'slug' => $this->slug,
            'icon' => $this->icon ?? null,
            'summary' => $this->summary ?? null,
            'provider_count' => $this->providers_count ?? 0,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name ?? null,
            ],
            // No deep nesting - just what's needed for feed
        ];
    }
}

