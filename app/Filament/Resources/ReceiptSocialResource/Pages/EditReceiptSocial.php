<?php

namespace App\Filament\Resources\ReceiptSocialResource\Pages;

use App\Filament\Resources\ReceiptSocialResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceiptSocial extends EditRecord
{
    protected static string $resource = ReceiptSocialResource::class;

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
