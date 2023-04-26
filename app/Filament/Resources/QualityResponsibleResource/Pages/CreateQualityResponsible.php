<?php

namespace App\Filament\Resources\QualityResponsibleResource\Pages;

use App\Filament\Resources\QualityResponsibleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQualityResponsible extends CreateRecord
{
    protected static string $resource = QualityResponsibleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
