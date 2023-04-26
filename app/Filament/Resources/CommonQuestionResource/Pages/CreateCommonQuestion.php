<?php

namespace App\Filament\Resources\CommonQuestionResource\Pages;

use App\Filament\Resources\CommonQuestionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCommonQuestion extends CreateRecord
{
    protected static string $resource = CommonQuestionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
