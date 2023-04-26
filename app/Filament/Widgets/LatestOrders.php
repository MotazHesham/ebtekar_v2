<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'أخر الطلبات';

    protected function getTableQuery(): Builder
    {
        return Order::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('order_num')
                ->label('رقم الأوردر'),
            TextColumn::make('client_name')
                ->label('أسم العميل'),
            TextColumn::make('created_at')->dateTime(config('panel.date_format'))
                ->label('تاريخ الطلب'),
        ];
    }
}
