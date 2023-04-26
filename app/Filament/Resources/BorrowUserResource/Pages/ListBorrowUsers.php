<?php

namespace App\Filament\Resources\BorrowUserResource\Pages;

use App\Filament\Resources\BorrowUserResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorrowUsers extends ListRecords
{
    protected static string $resource = BorrowUserResource::class;

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
