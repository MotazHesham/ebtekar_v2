<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptSocialProduct extends Model
{
    use SoftDeletes;
    protected $table = 'receipt_social_products';

    public function receipt_social(){
        return $this->belongsTo(ReceiptSocial::class);
    }

    public function product(){
        return $this->belongsTo(ReceiptProduct::class,'receipt_product_id');
    }

    public function total(){
        return $this ->total + ($this ->extra_commission * $this->quantity);
    }
}
