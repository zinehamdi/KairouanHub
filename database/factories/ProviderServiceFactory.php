<?php

namespace Database\Factories;

use App\Models\ProviderProfile;
use App\Models\ProviderService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProviderService>
 */
class ProviderServiceFactory extends Factory
{
    protected $model = ProviderService::class;

    public function definition(): array
    {
        $min = fake()->numberBetween(10,100);
        return [
            'provider_id' => ProviderProfile::factory(),
            'service_id' => Service::factory(),
            'price_min' => $min,
            'price_max' => $min + fake()->numberBetween(20,200),
        ];
    }
}
