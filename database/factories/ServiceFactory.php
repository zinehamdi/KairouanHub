<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Service> */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = ucfirst($this->faker->unique()->words(asText: true));
        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name . '-' . $this->faker->unique()->numberBetween(1, 9999)),
            'summary' => $this->faker->boolean ? $this->faker->sentence(10) : null,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
