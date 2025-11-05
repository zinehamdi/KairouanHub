<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<JobRequest> */
class JobRequestFactory extends Factory
{
    protected $model = JobRequest::class;

    public function definition(): array
    {
        return [
            'client_id' => User::factory(),
            'category_id' => Category::factory(),
            'service_id' => Service::factory(),
            'details' => $this->faker->sentence(12),
            'photos_json' => [],
            'city' => $this->faker->randomElement(['Kairouan','Tunis','Sousse']),
            'status' => 'open',
        ];
    }
}
