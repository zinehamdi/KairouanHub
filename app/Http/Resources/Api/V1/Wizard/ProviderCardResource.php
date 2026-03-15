<?php

namespace App\Http\Resources\Api\V1\Wizard;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Provider Card Resource - For Social Feed
 * 
 * Flat structure with trust badges
 * Recommendation levels for community trust
 * Perfect for scrollable provider cards
 */
class ProviderCardResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'bio' => $this->bio ? substr($this->bio, 0, 100) : null, // Truncate for cards
            'city' => $this->city,
            'phone' => $this->phone,
            
            // Trust & Recommendation System
            'badge' => $this->getTrustBadge(),
            'recommendation_level' => $this->getRecommendationLevel(),
            'rating' => round($this->avg_rating ?? 0, 1),
            'completed_jobs' => $this->completed_jobs ?? 0,
            
            // Visual elements
            'photos' => $this->getPhotoUrls(),
            
            // Category (flat, not nested)
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name ?? null,
            ],
            
            // Social proof
            'is_featured' => $this->badge_level === 'gold' || $this->avg_rating >= 4.5,
        ];
    }

    /**
     * Get trust badge based on community validation
     * Bronze → Silver → Gold progression
     */
    private function getTrustBadge(): string
    {
        // Badge level from database (set by admin/community)
        if ($this->badge_level) {
            return $this->badge_level;
        }

        // Auto-calculate based on recommendations/completed jobs
        $score = ($this->completed_jobs ?? 0) + (($this->avg_rating ?? 0) * 10);
        
        if ($score >= 50) return 'gold';
        if ($score >= 20) return 'silver';
        return 'bronze';
    }

    /**
     * Get recommendation level for UI display
     * Based on community trust and validation
     */
    private function getRecommendationLevel(): string
    {
        $badge = $this->getTrustBadge();
        
        return match($badge) {
            'gold' => 'highly_recommended',
            'silver' => 'trusted',
            default => 'new',
        };
    }

    /**
     * Get photo URLs (first 3 for card preview)
     */
    private function getPhotoUrls(): array
    {
        $photos = $this->photos_json ?? [];
        return array_slice(array_map(function($photo) {
            return asset('storage/' . $photo);
        }, $photos), 0, 3);
    }
}

