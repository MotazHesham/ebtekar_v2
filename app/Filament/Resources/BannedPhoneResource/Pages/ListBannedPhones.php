<?php

namespace App\Filament\Resources\BannedPhoneResource\Pages;

use App\Filament\Resources\BannedPhoneResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBannedPhones extends ListRecords
{
    protected static string $resource = BannedPhoneResource::class;

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
