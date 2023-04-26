<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends Model
{

    use SoftDeletes;
    protected $table = 'social';

    protected $fillable = [
        'name',
        'photo',
        'created_at',
        'updated_at',
    ];

}
