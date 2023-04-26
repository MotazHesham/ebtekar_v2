<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowUser extends Model
{
    use SoftDeletes;
    protected $table = 'borrow_users';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'created_at',
        'updated_at',
    ];

    public function borrow(){
        return $this->hasMany(Borrow::class,'borrow_user_id');
    }
}
