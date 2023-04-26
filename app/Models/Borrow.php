<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
    use SoftDeletes;
    protected $table = 'borrow';

    protected $fillable = [
        'borrow_user_id',
        'amount',
        'status',
        'created_at',
        'updated_at',
    ];

    public function borrow_user(){
        return $this->belongsTo(BorrowUser::class,'borrow_user_id');
    }
}
