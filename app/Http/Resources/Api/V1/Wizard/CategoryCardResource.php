<?php

namespace App\Http\Resources\Api\V1\Wizard;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Category Card Resource - For Gradient Cards
 * 
 * Minimal data for visual-first design
 * Perfect for big gradient cards (gold/bronze/emerald/midnight)
 */
class CategoryCardResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ar' => $this->name_ar ?? null,
            'icon' => $this->icon ?? null,
            'service_count' => $this->services_count ?? 0,
            // Gradient color suggestion (can be overridden by frontend)
            'color' => $this->getGradientColor(),
        ];
    }

    /**
     * Suggest gradient color based on position
     * Frontend can override with custom palette
     */
    private function getGradientColor(): string
    {
        $colors = ['gold', 'bronze', 'emerald', 'midnight'];
        return $colors[($this->id - 1) % count($colors)];
    }
}

