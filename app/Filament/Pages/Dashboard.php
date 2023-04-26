<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestOrders;
use App\Filament\Widgets\OrderChart;
use App\Filament\Widgets\ReceiptSocialChart;
use App\Filament\Widgets\SettingsOverview;
use App\Filament\Widgets\StatsDashboard;
use App\Filament\Widgets\StatsProducts;
use Closure;
use Illuminate\Support\Facades\Route;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament::pages.dashboard';

    protected static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? static::$title ?? __('filament::pages/dashboard.title');
    }

    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/', static::class)->name(static::getSlug());
        };
    }

    protected function getWidgets(): array
    {
        return [
            StatsDashboard::class,
            ReceiptSocialChart::class,
            OrderChart::class,
            LatestOrders::class,
            StatsProducts::class,
            SettingsOverview::class,
        ];
    }

    protected function getColumns(): int | array
    {
        return 2;
    }

    protected function getTitle(): string
    {
        return static::$title ?? __('filament::pages/dashboard.title');
    }
}
