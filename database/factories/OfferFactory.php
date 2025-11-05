<?php

namespace Database\Factories;

use App\Models\JobRequest;
use App\Models\Offer;
use App\Models\ProviderProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Offer> */
class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        return [
            'request_id' => JobRequest::factory(),
            'provider_id' => ProviderProfile::factory(),
            'price' => $this->faker->numberBetween(50, 500),
            'eta_days' => $this->faker->numberBetween(1, 14),
            'note' => $this->faker->sentence(10),
            'status' => 'pending',
        ];
    }
}
