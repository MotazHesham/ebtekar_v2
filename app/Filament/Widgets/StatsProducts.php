<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsProducts extends BaseWidget
{

    protected int | string | array $columnSpan = 'half';

    protected function getCards(): array
    {
        return [
            Card::make('المنتجات المنشورة', Product::where('published',1)->count())
                ->chart([1,1])
                ->color('warning')
                ->url(route('filament.resources.products.index')),
            Card::make('الفئات', Category::count())
                ->chart([1,1])
                ->color('success')
                ->url(route('filament.resources.categories.index')),
            Card::make('فئة فرعية', SubCategory::count())
                ->chart([1,1])
                ->color('danger')
                ->url(route('filament.resources.sub-categories.index')),
            Card::make('فئة فرعية لفئة فرعية', SubSubCategory::count())
                ->chart([1,1])
                ->color('primary')
                ->url(route('filament.resources.sub-sub-categories.index')),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }
}
