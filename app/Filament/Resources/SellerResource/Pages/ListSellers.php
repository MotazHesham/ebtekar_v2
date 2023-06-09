<?php

namespace App\Filament\Resources\SellerResource\Pages;

use App\Filament\Resources\SellerResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSellers extends ListRecords
{
    protected static string $resource = SellerResource::class;

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
