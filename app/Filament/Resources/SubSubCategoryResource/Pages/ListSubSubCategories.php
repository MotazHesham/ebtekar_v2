<?php

namespace App\Filament\Resources\SubSubCategoryResource\Pages;

use App\Filament\Resources\SubSubCategoryResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubSubCategories extends ListRecords
{
    protected static string $resource = SubSubCategoryResource::class;

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
