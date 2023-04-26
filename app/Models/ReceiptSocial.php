<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptSocial extends Model
{
    use Auditable;
    use SoftDeletes;

    protected $table = 'receipt_social';

    const DELIVERY_STATUS_SELECT = [
        'pending' => 'Pending',
        'on_review' => 'On review',
        'on_delivery' => 'On delivery',
        'delivered' => 'Delivered',
        'delay' => 'Delay',
        'cancel' => 'Cancel',
    ];

    const PAYMENT_STATUS_SELECT = [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid'
    ];

    const TYPE_SELECT = [
        'individual' => 'Individual',
        'corporate' => 'Corporate',
    ];

    protected $fillable = [
        'order_num',
        'type',
        'receipt_type',

        'client_name',
        'phone_number',
        'phone_number2',

        'deposit',
        'discount',
        'commission',
        'extra_commission',
        'total_cost',

        'done',
        'printing_times',
        'quickly',
        'confirm',
        'returned',
        'supplied',

        'date_of_receiving_order',
        'deliver_date',
        'sent_to_wasla_date',
		'done_time',

        'delivery_status',
        'payment_status',

        'shipping_country_id',
        'shipping_country_name',
        'shipping_country_cost',
        'shipping_address',

        'cancel_reason',
        'delay_reason',
        'note',

        'delivery_man_id',
        'staff_id',

        'playlist_status',
        'send_to_playlist_date',
        'designer_id',
        'preparer_id',
        'manifacturer_id',
        'send_to_delivery_id',
        'delivery_man_id',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function receipt_social_products(){
        return $this->hasMany(ReceiptSocialProduct::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function delivery_man()
    {
        return $this->belongsTo(User::class, 'delivery_man_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'shipping_country_id');
    }

    public function socials()
    {
        return $this->belongsToMany(Social::class, 'social_receipt_social','receipt_social_id','social_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' .config('panel.time_format')) : null;
    }

    public function getSendToPlaylistDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format') . ' ' .config('panel.time_format')) : null;
    }

	// operations
	public function calc_discount(){
		$total = ($this->total_cost + $this->extra_commission) / 100;
		return round( ($total * $this->discount ) , 2);
	}

	public function calc_total_cost(){
		return $this->total_cost + $this->extra_commission;
	}

	public function calc_total_for_delivery(){
		return $this->total_cost + $this->extra_commission  - $this->deposit;
	}

	public function calc_total(){
		return $this->total_cost + $this->extra_commission + $this->shipping_country_cost;
	}

	// formatting columns
	public function delivery_status(){
		return __(ucfirst(str_replace('_', ' ', $this->delivery_status)));
	}

	public function payment_status(){
		return __(ucfirst($this->payment_status));
	}

}
