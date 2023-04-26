<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public $table = 'subscribers';

    protected $fillable = [
        'name',
        'email',
        'created_at',
        'updated_at',
    ];
}
