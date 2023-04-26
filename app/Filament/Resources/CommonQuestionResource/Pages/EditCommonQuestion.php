<?php

namespace App\Filament\Resources\CommonQuestionResource\Pages;

use App\Filament\Resources\CommonQuestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommonQuestion extends EditRecord
{
    protected static string $resource = CommonQuestionResource::class;

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
