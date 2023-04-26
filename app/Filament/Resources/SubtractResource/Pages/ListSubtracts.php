<?php

namespace App\Filament\Resources\SubtractResource\Pages;

use App\Filament\Resources\SubtractResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubtracts extends ListRecords
{
    protected static string $resource = SubtractResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('borrow_users')->label(__('cruds.borrow_user.button'))
                    ->url(fn (): string => route('filament.resources.borrow-users.index'))
                    ->color('warning'),
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (): string => '';
    }
}
