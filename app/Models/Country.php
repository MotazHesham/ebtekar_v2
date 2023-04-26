<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    public $table = 'countries';

    protected $fillable = [
        'name',
        'cost',
        'code',
        'code_cost',
        'type',
        'status',
        'website',
        'created_at',
        'updated_at',
    ];

    public function getNamingAttribute(){
        return currency_formatting($this->cost) . ' - ' . $this->name;
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
