<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptPriceView extends Model
{
    use Auditable;
    use SoftDeletes;
    protected $table = 'receipt_price_view';

    protected $casts = [
        'added_value' => 'boolean',
    ];

    protected $fillable = [
        'client_name',
        'phone_number',
        'order_num',
        'staff_id',
        'total_cost',
        'place',
        'relate_duration',
        'supply_duration',
        'payment',
        'added_value',
        'printing_times',
        'date_of_receiving_order',
        'created_at',
        'updated_at',
    ];

    public function receipt_price_view_products(){
        return $this->hasMany(ReceiptPriceViewProducts::class,'receipt_price_view_id');
    }

    public function Staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
