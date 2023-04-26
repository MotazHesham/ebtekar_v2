<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use SoftDeletes;
    protected $table = 'sellers';

    protected $fillable = [
        'user_id',
        'seller_type',
        'discount_code',
        'discount',
        'verification_status',
        'order_out_website',
        'order_in_website',
        'qualification',
        'identity_front',
        'identity_back',
        'social_name',
        'social_link',
        'seller_code',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
