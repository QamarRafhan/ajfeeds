<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    /** @use HasFactory<\Database\Factories\StockLogFactory> */
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'quantity', 'reference_type', 'reference_id', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
