<?php

namespace App\Filament\Resources\AttributeResource\Pages;

use App\Filament\Resources\AttributeResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttributes extends ListRecords
{
    protected static string $resource = AttributeResource::class;

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
