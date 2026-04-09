<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reference_no' => 'ORD-' . strtoupper($this->faker->unique()->bothify('??###?')),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_amount' => 0, // Calculated in Seeder
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
