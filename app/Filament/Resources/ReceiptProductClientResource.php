<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptProductClientResource\Pages;
use App\Filament\Resources\ReceiptProductClientResource\RelationManagers;
use App\Models\ReceiptProduct;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class ReceiptProductClientResource extends Resource
{
    protected static ?string $model = ReceiptProduct::class;

    protected static ?string $slug = 'receipt-product-clients';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('cruds.receipt_product.receipt_product_client');
    }


    public static function getPluralLabel(): string
    {
        return __('cruds.receipt_product.receipt_product_client');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('name')->label(trans('cruds.receipt_product.fields.name'))
                    ->required(),
                Forms\Components\TextInput::make('price')->label(trans('cruds.receipt_product.fields.price'))
                    ->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(trans('cruds.receipt_product.fields.name'))->searchable(),
                Tables\Columns\TextColumn::make('receipts')->label(trans('cruds.receipt_product.receipts'))
                ->getStateUsing(function (Model $record): String{
                    $span1 = $record->product_client_receipts[0]['quantity'] ??  null;
                    $span2 = $record->product_client_receipts[0]['total'] ??  null;
                    $echo = '<div class="flex space-x-4">';
                    $echo .= $span1 ? '<div><span class="bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">' . $span1 . '</span></div>' : '';
                    $echo .= $span2 ?'<div><span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">' . currency_formatting($span2) . '</span></div>' : '';
                    $echo .='</div>';
                    return $echo;
                })->html(),
                Tables\Columns\TextColumn::make('price')->label(trans('cruds.receipt_product.fields.price')),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                Filter::make('date')->form([
                    Fieldset::make('Date')->label('أحصائيات')
                        ->schema([
                            Forms\Components\DatePicker::make('created_from')->label(__('global.created_from')),
                            Forms\Components\DatePicker::make('created_until')->label(__('global.created_until')),
                        ])->columns(1)
                ])->query(function (Builder $query, array $data): Builder {
                    return $query;
                })->indicateUsing(function (array $data): array {
                    $indicators = [];

                    if ($data['created_from'] ?? null) {
                        $indicators['created_from'] = 'Created from ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString();
                    }

                    if ($data['created_until'] ?? null) {
                        $indicators['created_until'] = 'Created until ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString();
                    }

                    return $indicators;
                }),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReceiptProductClients::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        global $created_from ,$created_until;
        $created_from = request('created_from') ?? null;
        $created_until = request('created_until') ?? null;
        $data = parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ])
                ->where('type','client')
                ->with('product_client_receipts',function($q){
                    if($GLOBALS['created_from'] != null || $GLOBALS['created_until'] != null){
                        $q->whereBetween('created_at',[$GLOBALS['created_from'] . ' 00:00:00',$GLOBALS['created_until'] . ' 00:00:00']);
                    }
                    $q->whereHas('receipt_client',function($query){
                        $query->where('done',1);
                    })
                    ->selectRaw('receipt_product_id, sum(quantity) as quantity,sum(total) as total')
                    ->groupBy('receipt_product_id');
                });
        return $data;
    }
}
