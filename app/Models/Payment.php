<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = ['reference_type', 'reference_id', 'type', 'amount', 'method'];

    public function reference()
    {
        return $this->morphTo();
    }
}
