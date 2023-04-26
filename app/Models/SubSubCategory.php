<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubCategory extends Model
{

    use SoftDeletes;
    public $table = 'sub_sub_categories';

    protected $fillable = [
        'name',
        'sub_category_id',
        'slug',
        'meta_title',
        'meta_description',
        'created_at',
        'updated_at',
    ];

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subsubcategory_id');
    }

}
