<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;
    public $table = 'categories';

    protected $fillable = [
        'name',
        'banner',
        'icon',
        'sort',
        'featured',
        'top',
        'slug',
        'meta_title',
        'meta_description',
        'created_at',
        'updated_at',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function classified_products()
    {
        return $this->hasMany(CustomerProduct::class);
    }
}
