<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'added_by', 'user_id', 'category_id', 'subcategory_id','subsubcategory_id',
        'unit_price', 'purchase_price','slug','attributes','choice_options','colors','tags',
        'video_provider','video_link','description','unit','photos','pdf','discount','discount_type',
        'meta_title','meta_description', 'flash_deal','published','featured','todays_deal','variant_product'
    ];

    public function product_stock()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subsubcategory()
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }


    //operations
    public function calc_discount($unit_price){
        if($this->discount > 0){
            if($this->discount_type == 'flat'){
                return $unit_price - $this->discount;
            }elseif($this->discount_type == 'percent'){
                $amount = ($unit_price / 100) * $this->discount;
                return $unit_price - $amount;
            }
        }
    }
}
