<?php

namespace Application\Providers\UseCases;

use App\Models\ProviderProfile;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * AttachServicesToProviderHandler
 * EN: Sync services for provider with optional pricing.
 * AR: مزامنة الخدمات للمزود مع التسعير الاختياري.
 */
class AttachServicesToProviderHandler
{
    /**
     * @param ProviderProfile $profile
     * @param array<int,array{service_id:int,price_min?:int,price_max?:int}> $services
     */
    public function handle(ProviderProfile $profile, array $services): ProviderProfile
    {
        if (empty($services)) {
            throw new InvalidArgumentException('At least one service required');
        }

        $sync = [];
        foreach ($services as $svc) {
            $service = Service::findOrFail($svc['service_id']);
            $min = $svc['price_min'] ?? null;
            $max = $svc['price_max'] ?? null;
            if ($min !== null && $max !== null && $min > $max) {
                throw new InvalidArgumentException('price_min cannot exceed price_max');
            }
            $sync[$service->id] = ['price_min' => $min, 'price_max' => $max];
        }

        DB::transaction(fn() => $profile->services()->sync($sync));

        return $profile->refresh();
    }
}
