<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ReceiptCompany extends Model
{
    use Auditable;
    use SoftDeletes;
    protected $table = 'receipt_comapny';

    const TYPE_SELECT = [
        'individual' => 'Individual',
        'corporate' => 'Corporate',
    ];

    protected $fillable = [
        'order_num',
        'client_name',
        'phone_number',
        'phone_number2',
        'deliver_date',
        'shipping_address',
        'total_cost',
        'shipping_country_cost',
        'deposit',
        'description',
        'staff_id',
        'note',
        'delivery_status',
        'payment_status',
        'shipping_country_id',
        'shipping_country_name',
        'delivery_man_id',
        'cancel_reason',
        'delay_reason',
        'calling',
        'date_of_receiving_order',
        'printing_times',
        'type',
        'quickly',
        'done',
        'no_answer',
        'sent_to_wasla_date',
        'done_time',
        'photos',
        'playlist_status',
        'send_to_playlist_date',
        'designer_id',
        'preparer_id',
        'manifacturer_id',
        'send_to_delivery_id',
        'supplied',
        'created_at',
        'updated_at',
    ];

    public function Staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function DeliveryMan()
    {
        return $this->belongsTo(User::class, 'delivery_man_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'shipping_country_id');
    }


	public function calc_total(){
		return $this->total_cost + $this->shipping_country_cost;
	}


    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' .config('panel.time_format')) : null;
    }

    public function getSendToPlaylistDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' .config('panel.time_format')) : null;
    }
}
