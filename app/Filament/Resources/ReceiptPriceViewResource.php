<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptPriceViewResource\Pages;
use App\Filament\Resources\ReceiptPriceViewResource\RelationManagers;
use App\Models\ReceiptPriceView;
use App\Models\ReceiptPriceViewProducts;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptPriceViewResource extends Resource
{
    protected static ?string $model = ReceiptPriceView::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('cruds.receipt_price_view.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.receipt_price_view.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.receipt_price_view.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.receipt_price_view.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('client_name')
                            ->required()
                            ->label(__('cruds.receipt_price_view.fields.client_name')),
                TextInput::make('phone_number')
                            ->label(__('cruds.receipt_price_view.fields.phone_number'))
                            ->required()
                            ->regex('/(01)[0-9]{9}/'),
                TextInput::make('relate_duration')
                            ->label(__('cruds.receipt_price_view.fields.relate_duration')),
                TextInput::make('supply_duration')
                            ->label(__('cruds.receipt_price_view.fields.supply_duration')),
                TextInput::make('payment')
                            ->numeric()
                            ->label(__('cruds.receipt_price_view.fields.payment')),
                TextInput::make('place')
                            ->label(__('cruds.receipt_price_view.fields.place')),
                Toggle::make('added_value')
                            ->label(__('cruds.receipt_price_view.fields.added_value')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->contentGrid([
            'md' => 2,
            'lg' => 2,
            'xl' => 2,
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

                        Split::make([
                            BadgeColumn::make('added_value')
                                ->colors(['primary'])
                                ->getStateUsing(function (): String {
                                    return '14%';
                                }),
                            IconColumn::make('added_value')->boolean()
                                ->toggle(),
                        ]),
                    ])->space(2),
                    Stack::make([
                        BadgeColumn::make('total_cost')->colors([
                            'secondary',
                        ])->getStateUsing(function (Model $record): String {
                            return __('cruds.receipt_price_view.fields.total_cost') . ' ' . currency_formatting($record->total_cost);
                        }),
                        BadgeColumn::make('payment')->colors([
                            'success',
                        ])->getStateUsing(function (Model $record): String {
                            return __('cruds.receipt_price_view.fields.payment') . ' ' . $record->payment;
                        }),
                        BadgeColumn::make('supply_duration')->colors([
                            'warning',
                        ])->getStateUsing(function (Model $record): String {
                            return __('cruds.receipt_price_view.fields.supply_duration') . ' ' . $record->supply_duration;
                        }),
                        BadgeColumn::make('relate_duration')->colors([
                            'danger',
                        ])->getStateUsing(function (Model $record): String {
                            return __('cruds.receipt_price_view.fields.relate_duration') . ' ' . $record->relate_duration;
                        }),
                    ])->space(1),
                ]),
                Panel::make([
                    TextColumn::make('place')->searchable(),
                    Split::make([
                        Stack::make([
                            BadgeColumn::make('created_at')
                                ->colors(['danger'])
                                ->getStateUsing(function (): String {
                                    return __('cruds.receipt_price_view.fields.created_at');
                                }),
                            TextColumn::make('created_at')->dateTime(config('panel.date_format')),
                        ]),
                        BadgeColumn::make('staff.name')->colors([
                            'success',
                        ]),
                    ]),
                ])->collapsible(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('staff')
                            ->label(__('cruds.receipt_price_view.fields.staff_id'))->relationship('staff', 'name'),
                TernaryFilter::make('added_value')
                            ->label(__('cruds.receipt_price_view.fields.added_value')),
                Filter::make('date')
                    ->form([
                        Fieldset::make('Date')
                            ->label('')
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
                        ->action(function (ReceiptPriceView $record, array $data): void {

                            $receipt = new ReceiptPriceViewProducts();
                            $receipt->receipt_price_view_id = $record->id;
                            $receipt->description = $data['description'];
                            $receipt->quantity = $data['quantity'];
                            $receipt->price = $data['price'];
                            $receipt->total_cost = ($data['quantity'] * $data['price']);
                            $receipt->save();

                            $receipt_products = ReceiptPriceViewProducts::where('receipt_price_view_id', $record->id)->get();
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
                        ->label(__('global.buttons.view_products'))
                        ->icon('heroicon-s-cube')
                        ->action(fn () => null)
                        ->form([
                            ViewField::make('Products')->view('receipts.price_view.products')
                        ]),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListReceiptPriceViews::route('/'),
            'create' => Pages\CreateReceiptPriceView::route('/create'),
            'edit' => Pages\EditReceiptPriceView::route('/{record}/edit'),
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
