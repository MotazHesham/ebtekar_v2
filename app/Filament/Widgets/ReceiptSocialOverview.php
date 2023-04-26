<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ReceiptSocialOverview extends BaseWidget
{

    protected function getCards(): array
    {
        Session::put('stats',false);
        return [
            Card::make('Receipts', session('receipts_count')),
            Card::make('Total Cost', session('total_cost')),
            Card::make('Commissions', session('commissions')),
        ];
    }
}
