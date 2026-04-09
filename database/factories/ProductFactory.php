<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $brands = ['AJ', 'Eco', 'Super', 'Nutra', 'Max', 'Pro', 'Agri', 'Safe'];
        $types = ['Layer', 'Broiler', 'Cattle', 'Horse', 'Goat', 'Fish'];
        $stages = ['Starter', 'Finisher', 'Grower', 'Breeder', 'Maintainer'];
        
        $brand = $this->faker->randomElement($brands);
        $type = $this->faker->randomElement($types);
        $stage = $this->faker->randomElement($stages);
        $name = "$brand $type $stage " . $this->faker->randomElement(['25kg', '50kg', 'Premix']);
        
        $purchasePrice = $this->faker->randomFloat(2, 500, 5000);
        
        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'description' => $this->faker->paragraph(2),
            'sku' => strtoupper($brand . '-' . $type . '-' . $this->faker->unique()->numberBetween(1000, 9999)),
            'purchase_price' => $purchasePrice,
            'sale_price' => $purchasePrice * 1.2,
            'stock_quantity' => $this->faker->numberBetween(10, 500),
            'min_stock_alert' => $this->faker->numberBetween(5, 20),
        ];
    }
}
