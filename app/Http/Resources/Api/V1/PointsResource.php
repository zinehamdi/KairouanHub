<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PointsResource extends JsonResource
{
    public function toArray($request): array
    {
        $transactions = collect($this->resource['transactions'] ?? []);

        return [
            'balance' => $this->resource['balance'] ?? 0,
            'transactions' => $transactions->map(function ($t) {
                return [
                    'id' => $t->id,
                    'type' => $t->type,
                    'points' => $t->points,
                    'reason' => $t->reason,
                    'related_type' => $t->related_type,
                    'related_id' => $t->related_id,
                    'meta' => $t->meta,
                    'created_at' => optional($t->created_at)->toIso8601String(),
                ];
            })->values(),
        ];
    }
}
