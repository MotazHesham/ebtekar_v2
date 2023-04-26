<?php

namespace App\Filament\Resources\ReceiptPriceViewResource\Pages;

use App\Filament\Resources\ReceiptPriceViewResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceiptPriceViews extends ListRecords
{
    protected static string $resource = ReceiptPriceViewResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (): string => '';
    }
}
