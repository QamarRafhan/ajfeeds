<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $types = ['Poultry', 'Cattle', 'Sheep', 'Goat', 'Fish', 'Bird', 'Horse', 'Camel'];
        $subtypes = ['Feed', 'Supplements', 'Medication', 'Equipment', 'Vitamins'];
        
        $name = $this->faker->randomElement($types) . ' ' . $this->faker->randomElement($subtypes);
        
        return [
            'name' => $name,
            'description' => $this->faker->sentence(10),
        ];
    }
}
