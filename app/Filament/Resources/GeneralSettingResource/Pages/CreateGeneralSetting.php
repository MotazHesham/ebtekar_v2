<?php

namespace App\Filament\Resources\GeneralSettingResource\Pages;

use App\Filament\Resources\GeneralSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeneralSetting extends CreateRecord
{
    protected static string $resource = GeneralSettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['photos'] = json_encode($data['photos']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
