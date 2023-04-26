<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $table = 'banners';

    protected $fillable = [
        'photo',
        'url',
        'position',
        'published',
        'created_at',
        'updated_at',
    ];
}
