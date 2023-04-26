<?php

namespace App\Filament\Resources\BorrowUserResource\Pages;

use App\Filament\Resources\BorrowUserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrowUser extends CreateRecord
{
    protected static string $resource = BorrowUserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
