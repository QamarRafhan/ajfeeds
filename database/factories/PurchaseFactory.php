<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'reference_no' => 'PUR-' . strtoupper($this->faker->unique()->bothify('??###?')),
            'status' => $this->faker->randomElement(['pending', 'received', 'cancelled']),
            'total_amount' => 0, // Calculated in Seeder
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
