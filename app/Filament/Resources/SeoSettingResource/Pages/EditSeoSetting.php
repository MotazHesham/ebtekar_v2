<?php

namespace App\Filament\Resources\SeoSettingResource\Pages;

use App\Filament\Resources\SeoSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoSetting extends EditRecord
{
    protected static string $resource = SeoSettingResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }



    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['keyword'] = explode(',',$data['keyword']);
        return $data;
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {

        $data['keyword'] = implode(',',$data['keyword']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
