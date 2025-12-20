<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ProviderSubmission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProviderSubmission>
 */
class ProviderSubmissionFactory extends Factory
{
    protected $model = ProviderSubmission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'provider_name' => $this->faker->company(),
            'phone' => '+216' . $this->faker->numerify('########'),
            'category_id' => Category::factory(),
            'city' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'status' => 'pending',
            'meta' => null,
        ];
    }
}
