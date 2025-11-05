<?php

namespace Database\Factories;

use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProviderProfile>
 */
class ProviderProfileFactory extends Factory
{
    protected $model = ProviderProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'display_name' => fake()->name(),
            'bio' => fake()->optional()->paragraph(),
            'city' => fake()->randomElement(['Kairouan','Tunis','Sousse']),
            'cities_json' => [fake()->city(), fake()->city()],
            'skills_json' => [fake()->word(), fake()->word(), fake()->word()],
            'photos_json' => [],
            'badge_level' => fake()->randomElement(['none','bronze','silver','gold']),
            'status' => fake()->randomElement(['pending','approved']),
            'avg_rating' => fake()->optional()->randomFloat(2, 0, 5),
            'completed_jobs' => fake()->numberBetween(0, 120),
            'social_json' => ['facebook' => 'https://facebook.com/'.fake()->userName()],
            'website' => fake()->optional()->url(),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn() => ['status' => 'approved']);
    }

    public function pending(): static
    {
        return $this->state(fn() => ['status' => 'pending']);
    }
}
