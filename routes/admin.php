<?php

use App\Http\Controllers\Admin\PlaylistController;
use App\Http\Controllers\Admin\ReceiptClientController;
use App\Http\Controllers\Admin\ReceiptCompanyController;
use App\Http\Controllers\Admin\ReceiptOutgoingsController;
use App\Http\Controllers\Admin\ReceiptSocialController;
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
*/


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {


    Route::get('receipt_social/product/delete/{id}', [ReceiptSocialController::class, 'delete_product'])->name('receipt_social.delete_product');
    Route::get('receipt_social/actions/{ids}/{action}', [ReceiptSocialController::class, 'actions'])->name('receipt_social.actions');


    Route::get('receipt_company/actions/{ids}/{action}', [ReceiptCompanyController::class, 'actions'])->name('receipt_company.actions');

    Route::get('receipt_client/product/delete/{id}', [ReceiptClientController::class, 'delete_product'])->name('receipt_client.delete_product');
    Route::get('receipt_client/actions/{ids}/{action}', [ReceiptClientController::class, 'actions'])->name('receipt_client.actions');

    Route::get('receipt_outgoings/actions/{ids}/{action}', [ReceiptOutgoingsController::class, 'actions'])->name('receipt_outgoings.actions');

    Route::get('playlist/print', [PlaylistController::class, 'print'])->name('playlist.print');
    Route::get('playlist/update_playlist_status', [PlaylistController::class, 'update_playlist_status'])->name('playlist.update_playlist_status');
    Route::get('playlist/qr_scanner', [PlaylistController::class], 'qr_scanner')->name('playlist.qr_scanner');
    Route::post('playlist/qr_output', [PlaylistController::class], 'qr_output')->name('playlist.qr_output');
});
