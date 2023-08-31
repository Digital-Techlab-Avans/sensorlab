<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'product_code' => fake()->unique()->numberBetween(100000, 999999),
            'description' => fake()->optional(0.2)->text(),
            'archived' => null,
            'stock' => fake()->optional(0.1)->numberBetween(0, 100),
            'featured_date' => fake()->optional(0.2)->dateTimeBetween('-1 week'),
        ];
    }
}
