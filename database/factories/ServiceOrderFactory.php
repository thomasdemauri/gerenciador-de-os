<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceOrder>
 */
class ServiceOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'vehicle' => 'ABC-1E23',
            'total_services' => $this->faker->randomNumber(3),
            'total_products' => $this->faker->randomNumber(3),
            'discount' => 0,
            'total_so' => $this->faker->randomNumber(3),
            'data_os' => Carbon::now()
        ];
    }
}
