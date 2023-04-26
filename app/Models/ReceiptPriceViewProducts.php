<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptPriceViewProducts extends Model
{
    use SoftDeletes;
    protected $table = 'receipt_price_view_products';
    public function receipt_price_view(){
        return $this->belongsTo(ReceiptPriceView::class);
    }
}
