<?php

namespace App\Filament\Resources\ReceiptOutgoingResource\Pages;

use App\Filament\Resources\ReceiptOutgoingResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceiptOutgoings extends ListRecords
{
    protected static string $resource = ReceiptOutgoingResource::class;

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

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [9, 18, 40, 90];
    }
}
