<?php

namespace App\Filament\Resources\ReceiptProductClientResource\Pages;

use App\Filament\Resources\ReceiptProductClientResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReceiptProductClients extends ManageRecords
{
    protected static string $resource = ReceiptProductClientResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('stats')->label(trans('global.statistics'))
                ->color('warning')
                ->form([
                    Fieldset::make(' ')
                            ->schema([
                                DatePicker::make('created_from')->label(trans('global.created_from'))->required(),
                                DatePicker::make('created_until')->label(trans('global.created_until'))->required(),
                            ])->columns(2)
                ])
                ->action(function (array $data) {
                    return redirect()
                            ->route('filament.resources.receipt-product-clients.index',['created_from' => $data['created_from'], 'created_until' => $data['created_until']]);
                }),
            Actions\CreateAction::make()
                                ->mutateFormDataUsing(function (array $data): array {
                                    $data['type'] = 'client';
                                    return $data;
                                }),
        ];
    }
}
