<?php

namespace App\Filament\Resources\SubtractResource\Pages;

use App\Filament\Resources\SubtractResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubtract extends CreateRecord
{
    protected static string $resource = SubtractResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
