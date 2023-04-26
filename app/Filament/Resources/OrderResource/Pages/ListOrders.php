<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Country;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Session;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }

    public function mount(): void
    {
        $countries = Country::all();
        Session::put('countries',$countries);
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (): string => '';
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 2;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [9, 18, 40, 90];
    }
}
