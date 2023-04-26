<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannedPhone extends Model
{
    public $table = 'banned_phones';

    protected $fillable = [
        'phone_number',
        'reason',
        'created_at',
        'updated_at',
    ];
}
