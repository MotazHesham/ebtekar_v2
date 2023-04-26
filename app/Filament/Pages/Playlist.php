<?php

namespace App\Filament\Pages;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ReceiptCompanyResource;
use App\Http\Resources\ReceiptSocialResource;
use App\Models\Order;
use App\Models\ReceiptCompany;
use App\Models\ReceiptSocial;
use App\Models\User;
use Filament\Pages\Page;
use App\Support\Collection;

class Playlist extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.playlist';

    protected static ?int $navigationSort = 4;

    protected function getTitle(): string
    {
        return __('cruds.playlist.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.playlist.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.playlist.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.playlist.navigation_group');
    }

    protected function getViewData(): array
    {

        $users = User::whereIn('user_type',['staff','seller'])->get();

        $type = request('type') ?? 'design';

        $orders = Order::with('OrderDetails')->orderBy('send_to_playlist_date','desc')->where('playlist_status',$type);
        $receipt_companies = ReceiptCompany::orderBy('send_to_playlist_date','desc')->where('playlist_status',$type);
        $receipt_social = ReceiptSocial::with('receipt_social_products')->orderBy('send_to_playlist_date','desc')->where('playlist_status',$type);

        $order_num = null;
        $user_id = null;
        $description = null;
        $to_date = null;
        $view = 'by_date';

        if( request('view') != null){
            $view = request('view');
        }

        if( request('view') != null){
            $view = request('view');
        }

        if( request('to_date') != null){
            $to_date = strtotime(request('to_date'));
            $orders = $orders->whereDate('send_to_playlist_date',date('Y-m-d',$to_date).' 00:00:00');
            $receipt_companies = $receipt_companies->whereDate('send_to_playlist_date',date('Y-m-d',$to_date).' 00:00:00');
            $receipt_social = $receipt_social->whereDate('send_to_playlist_date',date('Y-m-d',$to_date).' 00:00:00');
        }
        if (request('order_num') != null){
            $order_num = request('order_num');
            $orders = $orders->where('order_num', 'like', '%'.request('order_num').'%');
            $receipt_companies = $receipt_companies->where('order_num', 'like', '%'.request('order_num').'%');
            $receipt_social = $receipt_social->where('order_num', 'like', '%'.request('order_num').'%');
        }

        if (request('description') != null){
            $description = request('description');
            $orders = $orders->whereHas('orderDetails', function ($query) use ($description){
                $query->where('description', 'like', '%'.$description.'%');
            });
            $receipt_companies = $receipt_companies->where('description', 'like', '%'.request('description').'%');
            $receipt_social = $receipt_social->whereHas('receipt_social_products', function ($query) use ($description){
                $query->where('description', 'like', '%'.$description.'%')
                    ->orWhere('title', 'like', '%'.$description.'%');
            });
        }

        $orders_collection = collect(OrderResource::collection($orders->get()));
        $receipt_companies_collection = collect(ReceiptCompanyResource::collection($receipt_companies->get()));
        $receipt_social_collection = collect(ReceiptSocialResource::collection($receipt_social->get()));

        $merge = $orders_collection->merge($receipt_companies_collection);
        $items = $merge->merge($receipt_social_collection)->sortBy('send_to_playlist_date')->reverse()->values()->all();

        if($view == 'by_date'){
            $dates = (new Collection($items))->groupBy(function($date) {
                return \Carbon\Carbon::parse($date['send_to_playlist_date'])->format('Y-m-d');
            })->paginate(6);
            $items = null;
        }else{
            $items = (new Collection($items))->paginate(9);
            $dates = null;
        }
        return [
            'users' => $users,
            'dates' => $dates,
            'items' => $items,
            'view' => $view,
            'type' => $type,
            'order_num' => $order_num,
            'user_id' => $user_id,
            'description' => $description,
            'to_date' => $to_date,
        ];
    }
}
