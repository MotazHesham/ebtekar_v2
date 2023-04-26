<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtract extends Model
{
    use SoftDeletes;
    protected $table = 'subtracts';

    protected $fillable = [
        'subtract_user_id',
        'amount',
        'reason',
        'created_at',
        'updated_at',
    ];

    public function subtract_user(){
        return $this->belongsTo(BorrowUser::class,'subtract_user_id');
    }
}
