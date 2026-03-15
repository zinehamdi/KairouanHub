<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    public function toArray($request): array
    {
        // Flatten structure for mobile - no deep nesting
        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'city' => $this->city,
            'cities' => $this->cities_json ?? [],
            'skills' => $this->skills_json ?? [],
            'photos' => $this->getPhotoUrls(),
            'badge' => $this->badge_level ?? 'bronze',
            'recommendation_level' => $this->getRecommendationLevel(),
            'rating' => round($this->avg_rating ?? 0, 1),
            'completed_jobs' => $this->completed_jobs ?? 0,
            'is_featured' => $this->badge_level === 'gold' || ($this->avg_rating ?? 0) >= 4.5,
            'website' => $this->website,
            'social' => $this->social_json ?? [],
            // Flat category (not nested)
            'category_id' => $this->category_id,
            'category_name' => $this->category->name ?? null,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }

    /**
     * Get recommendation level
     */
    private function getRecommendationLevel(): string
    {
        $badge = $this->badge_level ?? 'bronze';
        return match($badge) {
            'gold' => 'highly_recommended',
            'silver' => 'trusted',
            default => 'new',
        };
    }

    /**
     * Get photo URLs
     */
    private function getPhotoUrls(): array
    {
        $photos = $this->photos_json ?? [];
        return array_map(function($photo) {
            return asset('storage/' . $photo);
        }, $photos);
    }
}
