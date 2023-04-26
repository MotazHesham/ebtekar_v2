<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $table = 'sliders';

    protected $fillable = [
        'photo',
        'url',
        'published',
        'created_at',
        'updated_at',
    ];
}
