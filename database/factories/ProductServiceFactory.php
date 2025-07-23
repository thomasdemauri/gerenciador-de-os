<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ServiceOrder;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductService>
 */
class ProductServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_order_id' => ServiceOrder::factory(),
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->randomNumber(1),
            'unit_price' => $this->faker->randomFloat(2, 12, 100),
            'total_price' => $this->faker->randomFloat(2, 23, 300)
        ];
    }
}
