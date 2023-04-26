<?php

namespace App\Filament\Resources\QualityResponsibleResource\Pages;

use App\Filament\Resources\QualityResponsibleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQualityResponsible extends EditRecord
{
    protected static string $resource = QualityResponsibleResource::class;

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
