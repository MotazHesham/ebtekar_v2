<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{

    use SoftDeletes;
    public $table = 'sub_categories';

    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'meta_title',
        'meta_description',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subsubcategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function classified_products()
    {
        return $this->hasMany(CustomerProduct::class, 'subcategory_id');
    }
}
