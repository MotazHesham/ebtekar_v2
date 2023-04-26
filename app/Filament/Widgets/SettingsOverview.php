<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SettingsOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('أحصائيات الموقع', null)
                ->chart([1,1])
                ->color('default')
                ->url(route('filament.pages.filament-google-analytics-dashboard')),
            Card::make('أعدادات تحسين محركات البحث', null)
                ->chart([1,1])
                ->color('default')
                ->url(route('filament.resources.seo-settings.index')),
            Card::make('الأعدادت العامة', null)
                ->chart([1,1])
                ->color('default')
                ->url(route('filament.resources.general-settings.index')),
            Card::make('توصيل المحافظات', null)
                ->chart([1,1])
                ->color('default')
                ->url(route('filament.resources.countries.index')),
            Card::make('أعدادات صفحة سياسة الموقع', null)
                ->chart([1,1])
                ->color('default')
                ->url(route('filament.resources.policies.index')),
            Card::make('الفئات الرئيسية', null)
                ->chart([1,1])
                ->color('default')
                ->url(route('filament.resources.home-categories.index')),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
