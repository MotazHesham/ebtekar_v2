<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonQuestion extends Model
{

    public $table = 'common_questions';

    protected $fillable = [
        'question',
        'answer',
        'created_at',
        'updated_at',
    ];
}
