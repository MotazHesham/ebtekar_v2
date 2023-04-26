<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptClientProduct extends Model
{
    use SoftDeletes;
    protected $table = 'receipt_client_products';

    public function receipt_client(){
        return $this->belongsTo(ReceiptClient::class);
    }
}
