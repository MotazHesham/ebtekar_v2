<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Auditable;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('completed', function (Builder $builder) {
            $builder->where('completed', 1);
        });
    }

    public $table = 'orders';

    protected $fillable = [
        'user_id',
        'paymob_order_id',

        'shipping_country_id',
        'shipping_country_name',
        'shipping_country_cost',
        'free_shipping',
        'free_shipping_reason',
        'delivery_man',
        'shipping_cost_by_seller',

        'completed',
        'calling',
        'sent_to_wasla',
        'printing_times',
        'supplied',

        'total_cost_by_seller',
        'total_cost',
        'deposit',
        'deposit_amount',
        'commission',
        'extra_commission',
        'discount_code',
        'discount',

        'payment_status',
        'delivery_status',
        'payment_type',
        'order_type',

        'client_name',
        'order_num',
        'shipping_address',
        'phone_number',
        'phone_number2',

        'date_of_receiving_order',
        'excepected_deliverd_date',

        'cancel_reason',
        'delay_reason',
        'note',

        'playlist_status',
        'send_to_playlist_date',
        'designer_id',
        'preparer_id',
        'manifacturer_id',
        'send_to_delivery_id',
        'created_at',
        'updated_at',
    ];

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

    const PAYMENT_TYPE_SELECT = [
        'cash_on_delivery' => 'Cash On Delivery',
        'paymob' => 'Paymob'
    ];

    const ORDER_TYPE_SELECT = [
        'customer' => 'Customer',
        'seller' => 'Seller'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function deliveryMan()
    {
        return $this->belongsTo(User::class, 'delivery_man');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'shipping_country_id');
    }

    // operations

	// public function calc_total_cost(){
	// 	return $this->total_cost + $this->extra_commission;
	// }

	// public function calc_total_for_delivery(){
	// 	return $this->total_cost + $this->extra_commission  - $this->deposit;
	// }

    public function calc_discount(){
        return round( ( ($this->total_cost/100) * $this->discount ) , 2);
    }
	public function calc_total(){
		return $this->total_cost + $this->extra_commission + $this->shipping_country_cost - $this->calc_discount();
	}

	// formatting columns
	public function delivery_status(){
		return __(ucfirst(str_replace('_', ' ', $this->delivery_status)));
	}

	public function payment_status(){
		return __(ucfirst($this->payment_status));
	}
}
