<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptOutgoingsProducts extends Model
{
    use SoftDeletes;
    protected $table = 'receipt_outgoings_products';
    public function receipt_outgoings()
    {
        return $this->belongsTo(ReceiptOutgoings::class);
    }
}
