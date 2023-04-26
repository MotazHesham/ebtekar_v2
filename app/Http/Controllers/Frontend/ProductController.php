<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product($slug){

        $product  = Product::where('slug', $slug)->first();
        if(!$product){
            abort(404);
        }
        return view('frontend.product',compact('product'));
    }

    public function quick_view(Request $request){
        $product  = Product::findOrFail($request->id);
        return view('frontend.partials.quick_view',compact('product'));
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $available_quantity = 0;

        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('name', $request['color'])->first()->name;
        }

        if(json_decode(Product::find($request->id)->choice_options) != null){
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_'.$choice->attribute]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_'.$choice->attribute]);
                }
            }
        }

        if($str != null){
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->unit_price;
            $comission = ( $product_stock->unit_price - $product_stock->purchase_price);
            $available_quantity = $product_stock->quantity;
        }else{
            $price = $product->unit_price;
            $comission = ( $product->unit_price -$product->purchase_price );
            $available_quantity = $product->current_stock;
        }

        //discount calculation
        $before_discount = 0;
        if($product->discount_type == 'percent'){
            $before_discount = $price;
            $price -= ($price * $product->discount)/100;
        }elseif($product->discount_type == 'amount'){
            $before_discount = $price;
            $price -= $product->discount;
        }

        return array(
                        'discount' => $product->discount,
                        'before_discount' => front_currency($before_discount),
                        'price' => front_currency($price),
                        'commission' => front_currency($comission),
                        'variant' => $str,
                        'available_quantity' => $available_quantity,
                    );

    }

    public function search_by_category($id){
        $category = Category::findOrFail($id);
        $title = $category->name;
        $products = Product::where('category_id',$id)->where('published',1)->orderBy('created_at','desc')->paginate(12);
        // return $products->getUrlRange(1, 100);

        return view('frontend.products',compact('products','title'));
    }
    public function search_by_subcategory($id){
        $category = SubCategory::findOrFail($id);
        $title = $category->name;
        $products = Product::where('subcategory_id',$id)->where('published',1)->orderBy('created_at','desc')->paginate(12);

        return view('frontend.products',compact('products','title'));
    }
    public function search_by_subsubcategory($id){
        $category = SubSubCategory::findOrFail($id);
        $title = $category->name;
        $products = Product::where('subsubcategory_id',$id)->where('published',1)->orderBy('created_at','desc')->paginate(12);

        return view('frontend.products',compact('products','title'));
    }
}
