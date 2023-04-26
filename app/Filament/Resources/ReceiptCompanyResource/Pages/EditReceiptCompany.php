<?php

namespace App\Filament\Resources\ReceiptCompanyResource\Pages;

use App\Filament\Resources\ReceiptCompanyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceiptCompany extends EditRecord
{
    protected static string $resource = ReceiptCompanyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['photos'] = json_decode($data['photos']);
        return $data;
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {

        $data['photos'] = json_encode($data['photos']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
