<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptClient extends Model
{

    use Auditable;
    use SoftDeletes;
    protected $table = 'receipt_clients';

    protected $fillable = [
        'client_name',
        'phone_number',
        'order_num',
        'staff_id',
        'total_cost',
        'note',
        'done',
        'deposit',
        'discount',
        'printing_times',
        'quickly',
        'date_of_receiving_order',
        'created_at',
        'updated_at',
    ];
    public function receipt_client_products(){
        return $this->hasMany(ReceiptClientProduct::class);
    }

    public function Staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

	public function calc_total(){

        $discount = round( ( ($this->total_cost/100) * $this->discount ) , 2);
		return $this->total_cost - $discount;
	}


    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' .config('panel.time_format')) : null;
    }
}
