<?php

namespace App\Filament\Resources\ReceiptPriceViewResource\Pages;

use App\Filament\Resources\ReceiptPriceViewResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceiptPriceView extends EditRecord
{
    protected static string $resource = ReceiptPriceViewResource::class;

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
