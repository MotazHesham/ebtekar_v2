<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    public $table = 'brands';

    protected $fillable = [
        'name',
        'logo',
        'top',
        'slug',
        'meta_title',
        'meta_description',
        'created_at',
        'updated_at',
    ];
}
