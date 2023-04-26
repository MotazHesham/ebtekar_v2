<?php

namespace App\Filament\Resources\ReceiptClientResource\Pages;

use App\Filament\Resources\ReceiptClientResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceiptClient extends EditRecord
{
    protected static string $resource = ReceiptClientResource::class;

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
