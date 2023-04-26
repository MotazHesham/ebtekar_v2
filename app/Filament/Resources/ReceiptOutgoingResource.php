<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptOutgoingResource\Pages;
use App\Filament\Resources\ReceiptOutgoingResource\RelationManagers;
use App\Models\ReceiptOutgoing;
use App\Models\ReceiptOutgoingsProducts;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptOutgoingResource extends Resource
{
    protected static ?string $model = ReceiptOutgoing::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('cruds.receipt_outgoing.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.receipt_outgoing.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.receipt_outgoing.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.receipt_outgoing.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date_of_receiving_order')
                            ->label(__('cruds.receipt_outgoing.fields.date_of_receiving_order'))
                            ->columnSpan('full'),
                TextInput::make('client_name')
                            ->required()
                            ->label(__('cruds.receipt_outgoing.fields.client_name')),
                TextInput::make('phone_number')
                            ->required()
                            ->label(__('cruds.receipt_outgoing.fields.phone_number'))
                            ->regex('/(01)[0-9]{9}/'),
                RichEditor::make('note')
                            ->label(__('cruds.receipt_outgoing.fields.note'))
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ]),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table->contentGrid([
            'md' => 2,
            'lg' => 2,
            'xl' => 3,
        ])
            ->columns([
                Split::make([
                    Stack::make([
                        BadgeColumn::make('order_num')
                            ->colors([
                                'danger'
                            ])
                            ->icons([
                                'heroicon-o-qrcode',
                            ])->searchable(),
                        Stack::make([
                            TextColumn::make('client_name')->searchable(),
                            TextColumn::make('phone_number')->searchable(),
                        ])->space(1),
                    ])->space(2),
                    Stack::make([
                        BadgeColumn::make('total_cost')->colors([
                            'secondary',
                        ])->getStateUsing(function (Model $record): String {
                            return  __('cruds.receipt_outgoing.fields.total_cost') . ' ' . currency_formatting($record->total_cost);
                        }),

                        Split::make([
                            BadgeColumn::make('done')
                                ->colors(['primary'])
                                ->getStateUsing(function (): String {
                                    return __('cruds.receipt_outgoing.fields.done');
                                }),
                            IconColumn::make('done')->boolean()
                            ->toggle(),
                        ]),
                    ])->space(1),
                ]),
                Panel::make([
                    Stack::make([
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('created_at')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_outgoing.fields.created_at');
                                    }),
                                TextColumn::make('created_at')->dateTime(config('panel.date_format')),
                            ]),
                            Stack::make([
                                BadgeColumn::make('date_of_receiving_order')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_outgoing.fields.date_of_receiving_order');
                                    }),
                                TextColumn::make('date_of_receiving_order')->dateTime(config('panel.date_format')),
                            ]),
                        ]),
                        Stack::make([
                            BadgeColumn::make('note')->colors([
                                'success',
                            ])->getStateUsing(function (): String {
                                return __('cruds.receipt_outgoing.fields.note');
                            }),
                            TextColumn::make('note')->html()->searchable(),
                        ]),
                        Split::make([
                            BadgeColumn::make('staff.name')->colors([
                                'success',
                            ]),
                        ]),
                    ])->space(3),
                ])->collapsible(),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('staff')
                            ->label(__('cruds.receipt_outgoing.fields.staff_id'))->relationship('staff', 'name'),
                TernaryFilter::make('done')
                            ->label(__('cruds.receipt_outgoing.fields.done')),
                Filter::make('date')
                    ->form([
                        Fieldset::make('Date')->label('')
                            ->schema([
                                Forms\Components\Select::make('date')->label(__('cruds.receipt_outgoing.fields.date'))->options(['created_at' => 'تاريخ الأضافة']),
                                Forms\Components\DatePicker::make('created_from')->label(__('global.created_from')),
                                Forms\Components\DatePicker::make('created_until')->label(__('global.created_until')),
                            ])->columns(1)
                    ])->query(function (Builder $query, array $data): Builder {
                        $column = $data['date'] ?? 'created_at';
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate($column, '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate($column, '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ActionGroup::make([
                    Action::make('addProduct')
                        ->label(__('global.buttons.add_product'))
                        ->icon('heroicon-s-plus-circle')
                        ->color('success')
                        ->modalButton(__('global.buttons.add'))
                        ->action(function (ReceiptOutgoing $record, array $data): void {

                            $receipt = new ReceiptOutgoingsProducts();
                            $receipt->receipt_outgoings_id = $record->id;
                            $receipt->description = $data['description'];
                            $receipt->quantity = $data['quantity'];
                            $receipt->price = $data['price'];
                            $receipt->total_cost = ($data['quantity'] * $data['price']);
                            $receipt->save();

                            $receipt_products = ReceiptOutgoingsProducts::where('receipt_outgoings_id', $record->id)->get();
                            $sum = 0;
                            foreach ($receipt_products as $row) {
                                $sum += $row->total_cost;
                            }
                            $record->total_cost = $sum;
                            $record->save();

                            Notification::make()
                                ->title(__('global.notifications.product_added'))
                                ->success()
                                ->send();
                        })
                        ->form([
                            Grid::make(2)->schema([
                                TextInput::make('description')
                                            ->label(__('cruds.receipt_outgoing.products.product_name'))
                                            ->required(),
                                TextInput::make('quantity')
                                            ->label(__('cruds.receipt_outgoing.products.quantity'))
                                            ->required()->numeric(),
                                TextInput::make('price')
                                            ->label(__('cruds.receipt_outgoing.products.cost'))
                                            ->numeric()->required(),
                            ])
                        ]),
                    Action::make('viewProducts')
                        ->icon('heroicon-s-cube')
                        ->label(__('global.buttons.view_products'))
                        ->action(fn () => null)
                        ->form([
                            ViewField::make('Products')->view('receipts.outgoing.products')
                        ]),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\BulkAction::make('print')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_outgoings.actions',['ids' => $records->pluck('id'),'action' => 'print']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-printer'),
                Tables\Actions\BulkAction::make('download')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_outgoings.actions',['ids' => $records->pluck('id'),'action' => 'download']))
                    ->requiresConfirmation()
                    ->color('primary')
                    ->icon('heroicon-o-download'),
                Tables\Actions\BulkAction::make('stats')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_outgoings.actions',['ids' => $records->pluck('id'),'action' => 'stats']))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-chart-bar'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceiptOutgoings::route('/'),
            'create' => Pages\CreateReceiptOutgoing::route('/create'),
            'edit' => Pages\EditReceiptOutgoing::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
