<?php

namespace App\Filament\Resources\CommonQuestionResource\Pages;

use App\Filament\Resources\CommonQuestionResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommonQuestions extends ListRecords
{
    protected static string $resource = CommonQuestionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (): string => '';
    }
}
