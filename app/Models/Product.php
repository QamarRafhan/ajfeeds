<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'description', 'sku', 'purchase_price', 
        'sale_price', 'stock_quantity', 'min_stock_alert', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
