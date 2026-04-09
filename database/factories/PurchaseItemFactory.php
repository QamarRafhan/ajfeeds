<?php

namespace Database\Factories;

use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition(): array
    {
        return [
            'purchase_id' => Purchase::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(10, 100),
            'unit_price' => 0,
            'subtotal' => 0,
        ];
    }
}
