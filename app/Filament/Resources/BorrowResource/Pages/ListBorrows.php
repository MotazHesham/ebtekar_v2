<?php

namespace App\Filament\Resources\BorrowResource\Pages;

use App\Filament\Resources\BorrowResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorrows extends ListRecords
{
    protected static string $resource = BorrowResource::class;

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
