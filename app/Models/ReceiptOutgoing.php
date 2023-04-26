<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptOutgoing extends Model
{
    use Auditable;
    use SoftDeletes;
    protected $table = 'receipt_outgoings';

    protected $fillable = [
        'client_name',
        'phone_number',
        'order_num',
        'staff_id',
        'total_cost',
        'note',
        'done',
        'printing_times',
        'date_of_receiving_order',
        'created_at',
        'updated_at',
    ];

    public function receipt_outgoings_products(){
        return $this->hasMany(ReceiptOutgoingsProducts::class,'receipt_outgoings_id');
    }

    public function Staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
