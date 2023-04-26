<?php

namespace App\Filament\Resources\BannedPhoneResource\Pages;

use App\Filament\Resources\BannedPhoneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBannedPhone extends CreateRecord
{
    protected static string $resource = BannedPhoneResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
