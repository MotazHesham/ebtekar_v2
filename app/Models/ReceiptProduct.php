<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptProduct extends Model
{
    use Auditable;
    use SoftDeletes;

    protected $table = 'receipt_products';

    protected $fillable = [
        'name',
        'price',
        'type',
        'commission',
        'photos',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product_social_receipts(){
        return $this->hasMany(ReceiptSocialProduct::class,'receipt_product_id');
    }

    public function product_client_receipts(){
        return $this->hasMany(ReceiptClientProduct::class,'receipt_product_id');
    }
}
