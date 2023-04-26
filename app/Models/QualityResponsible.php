<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityResponsible extends Model
{
    protected $table = 'quality_responsible';

    protected $fillable = [
        'photo',
        'name',
        'phone_number',
        'wts_phone',
        'country_code',
        'created_at',
        'updated_at',
    ];
}
