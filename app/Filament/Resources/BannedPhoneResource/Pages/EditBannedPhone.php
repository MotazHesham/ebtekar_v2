<?php

namespace App\Filament\Resources\BannedPhoneResource\Pages;

use App\Filament\Resources\BannedPhoneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBannedPhone extends EditRecord
{
    protected static string $resource = BannedPhoneResource::class;

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
