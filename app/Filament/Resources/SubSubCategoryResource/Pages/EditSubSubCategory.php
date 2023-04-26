<?php

namespace App\Filament\Resources\SubSubCategoryResource\Pages;

use App\Filament\Resources\SubSubCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubSubCategory extends EditRecord
{
    protected static string $resource = SubSubCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
