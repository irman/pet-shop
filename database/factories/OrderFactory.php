<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid,
            'user_id' => 2,
            'order_status_uuid' => Order::DEFAULT_STATUS_UUID,
            'products' => [],
            'address' => [],
            'delivery_fee' => rand(0, 10),
            'amount' => fake()->randomFloat(2, 1, 9999),
        ];
    }
}
