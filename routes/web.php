<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

/*
    fixing old db to newer
*/
Route::get('fix_receipt_client_product',function(){
    // add receipt_product_id column
    $data = \App\Models\ReceiptClientProduct::all();
    foreach($data as $row){
        $receipt_product = \App\Models\ReceiptProduct::where('name',$row->description)->first();
        if($receipt_product){
            $row->receipt_product_id = $receipt_product->id;
            $row->save();
        }
    }
    return 1;
});
Route::get('fix_products',function(){
    $products = \App\Models\Product::get();

    foreach($products as $product){

        // change from attribute_id to attribute
            // if($product->choice_options != null){
                // $product->choice_options = str_replace('attribute_id','attribute',$product->choice_options);
                // $choice_options = json_decode($product->choice_options) ;
                // foreach ($choice_options as $key => $choice){
                //     if(\App\Models\Attribute::find($choice->attribute)){
                //         $choice_options[$key]->attribute = \App\Models\Attribute::find($choice->attribute)->name;
                //     }
                //     $product->choice_options = json_encode($choice_options);
                // }
            // }
        // ---------

        // change from amount to flat
            if($product->discount_type == 'amount'){
                $product->discount_type = 'flat';
            }
        // ---------
        $product->save();
    }
    return 1;
});

/*
    fixing old db to newer
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('frontend.about');
Route::get('/events', [HomeController::class, 'events'])->name('frontend.events');

// subscribers
Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('frontend.subscribe');

Auth::routes();


Route::group(['as' => 'frontend.'], function () {
    Route::post('product/quick_view', [ProductController::class, 'quick_view'])->name('product.quick_view');
    Route::post('product/variant_price', [ProductController::class, 'variant_price'])->name('product.variant_price');
    Route::get('product/{slug}', [ProductController::class, 'product'])->name('product');
    Route::get('products/category/{id}', [ProductController::class, 'search_by_category'])->name('products.category');
    Route::get('products/subcategory/{id}', [ProductController::class, 'search_by_subcategory'])->name('products.subcategory');
    Route::get('products/subsubcategory/{id}', [ProductController::class, 'search_by_subsubcategory'])->name('products.subsubcategory');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

        // checkout
        Route::get('payment_select', [CheckoutController::class, 'payment_select'])->name('payment_select');
        Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');

        // cart
        Route::get('cart', [CartController::class, 'index'])->name('cart');
        Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('cart/delete', [CartController::class, 'delete'])->name('cart.delete');


        // wishlist
        Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
        Route::get('/wishlist/add/{slug}', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::post('wishlist/delete', [WishlistController::class, 'delete'])->name('wishlist.delete');

        // orders
        Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
        Route::get('/orders/success/{id}', [OrderController::class, 'success'])->name('orders.success');
        Route::get('/orders/track/{id}', [OrderController::class, 'track'])->name('orders.track');

        // profile
        Route::post('/update_profile', [ProfileController::class, 'update_profile'])->name('update_profile');
        Route::post('/update_password', [ProfileController::class, 'update_password'])->name('update_password');
    });
});


