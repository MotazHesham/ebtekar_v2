<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\DoughnutChartWidget;

class OrderChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'الطلبات';

    public ?string $filter = 'year';

    protected static ?string $maxHeight = '270px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'My First Dataset',
                    'data' =>  [Order::where('order_type','customer')->count(),Order::where('order_type','seller')->count()],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'
                    ]
                ],
            ],
            'labels' => ['طلبات من قبل المستخدمين', 'طلبات من قبل البائعين'],
        ];
    }
    protected function getFilters(): ?array
    {
        return [
            'today' => 'اليوم',
            'week' => 'أخر أسبوع',
            'month' => 'أخر شهر',
            'year' => date('Y'),
        ];
    }
}
