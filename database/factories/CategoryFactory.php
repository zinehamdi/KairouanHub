<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Category> */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(asText: true);
        $name = is_string($name) ? $name : $this->faker->unique()->word();
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name . '-' . $this->faker->unique()->numberBetween(1, 9999)),
            'description' => $this->faker->boolean ? $this->faker->sentence(8) : null,
            'position' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(85),
        ];
    }
}
