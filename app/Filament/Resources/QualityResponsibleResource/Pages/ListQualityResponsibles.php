<?php

namespace App\Filament\Resources\QualityResponsibleResource\Pages;

use App\Filament\Resources\QualityResponsibleResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQualityResponsibles extends ListRecords
{
    protected static string $resource = QualityResponsibleResource::class;

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
