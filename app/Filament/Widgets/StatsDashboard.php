<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReceiptSocial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use \Carbon\Carbon;

class StatsDashboard extends BaseWidget
{
    protected function getCards(): array
    {
        // customers count last 7 days
        $customers = Customer::whereBetween('created_at', [now()->subDays(7), now()])->orderBy('created_at')->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('d');
                        });
        $customer_list = [];
        $customer_count = 0;
        foreach($customers as $customer){
            $customer_list[] = $customer->count();
            $customer_count += $customer->count();
            if($customers->count() == 1){
                $customer_list[] = $customer->count();
            }
        }

        // products count last 7 days
        $products = Product::whereBetween('created_at', [now()->subDays(30), now()])->orderBy('created_at')->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('d');
                        });
        $product_list = [];
        $product_count = 0;
        foreach($products as $product){
            $product_list[] = $product->count();
            $product_count += $product->count();
            if($products->count() == 1){
                $product_list[] = $product->count();
            }
        }

        // orders count last 7 days
        $orders = Order::whereBetween('created_at', [now()->subDays(30), now()])->orderBy('created_at')->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('d');
                        });
        $order_list = [];
        $order_count = 0;
        foreach($orders as $order){
            $order_list[] = $order->count();
            $order_count += $order->count();
            if($orders->count() == 1){
                $order_list[] = $order->count();
            }
        }

        // receipts social count last 7 days
        $receipts_social = ReceiptSocial::whereBetween('created_at', [now()->subDays(30), now()])->orderBy('created_at')->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('d');
                        });
        $receipt_social_list = [];
        $receipt_social_count = 0;
        foreach($receipts_social as $receipt_social){
            $receipt_social_list[] = $receipt_social->count();
            $receipt_social_count += $receipt_social->count();
            if($receipts_social->count() == 1){
                $receipt_social_list[] = $receipt_social->count();
            }
        }

        return [
            Card::make('المستخدمين', Customer::count())
                ->description(' +' . $customer_count . ' Registerd ')
                ->chart($customer_list)
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('primary')
                ->url(route('filament.resources.users.index')),
            Card::make('المنتجات', Product::count())
                ->description(' +' . $product_count . ' New ')
                ->chart($product_list)
                ->descriptionIcon('heroicon-s-plus-circle')
                ->color('warning')
                ->url(route('filament.resources.products.index')),
            Card::make('الطلبات', Order::count())
                ->description(' +' . $order_count . ' Orderd ')
                ->chart($order_list)
                ->descriptionIcon('heroicon-s-plus-circle')
                ->color('success')
                ->url(route('filament.resources.orders.index')),
            Card::make('فواتير السوشيال', ReceiptSocial::count())
                ->description(' +' . $receipt_social_count . ' New ')
                ->chart($receipt_social_list)
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger')
                ->url(route('filament.resources.receipt-socials.index')),

        ];
    }
}
