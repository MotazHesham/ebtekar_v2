<?php

namespace App\Filament\Widgets;

use App\Models\ReceiptClient;
use App\Models\ReceiptCompany;
use App\Models\ReceiptSocial;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ReceiptSocialChart extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    public ?string $filter = 'year';


    protected function getHeading(): string
    {
        return 'الفواتير';
    }

    protected function getData(): array
    {
        $receipts_social = Trend::model(ReceiptSocial::class)
                                ->between(
                                    start: now()->startOfYear(),
                                    end: now()->endOfYear(),
                                )
                                ->perMonth()
                                ->count();
        $receipts_company = Trend::model(ReceiptCompany::class)
                                ->between(
                                    start: now()->startOfYear(),
                                    end: now()->endOfYear(),
                                )
                                ->perMonth()
                                ->count();
        $receipts_client = Trend::model(ReceiptClient::class)
                                ->between(
                                    start: now()->startOfYear(),
                                    end: now()->endOfYear(),
                                )
                                ->perMonth()
                                ->count();

        return [
            'datasets' => [
                [
                    'label' => 'فواتير السوشيال',
                    'data' => $receipts_social->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(75, 192, 192)',
                ],
                [
                    'label' => 'فواتير أبتكار',
                    'data' => $receipts_company->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(209,156,146)',
                ],
                [
                    'label' => 'فواتير شركات',
                    'data' => $receipts_client->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgb(156,146,209)',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
