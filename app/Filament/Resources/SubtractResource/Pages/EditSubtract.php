<?php

namespace App\Filament\Resources\SubtractResource\Pages;

use App\Filament\Resources\SubtractResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubtract extends EditRecord
{
    protected static string $resource = SubtractResource::class;

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
