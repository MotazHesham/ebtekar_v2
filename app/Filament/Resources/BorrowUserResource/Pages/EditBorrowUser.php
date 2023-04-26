<?php

namespace App\Filament\Resources\BorrowUserResource\Pages;

use App\Filament\Resources\BorrowUserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBorrowUser extends EditRecord
{
    protected static string $resource = BorrowUserResource::class;

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
