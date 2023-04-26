<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;
    public $table = 'attributes';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];
}
