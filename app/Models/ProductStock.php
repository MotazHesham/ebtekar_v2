<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{
    use SoftDeletes;
    protected $fillable = ['variant', 'unit_price', 'purchase_price', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
