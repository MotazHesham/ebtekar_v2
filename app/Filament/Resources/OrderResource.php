<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('cruds.order.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.order.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.order.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.order.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                        BadgeColumn::make('order_num')->colors(['danger'])
                            ->icons(['heroicon-o-qrcode',])->searchable(),
                        Stack::make([
                            TextColumn::make('client_name')->searchable(),
                            TextColumn::make('phone_number')->searchable(),
                            TextColumn::make('phone_number2')->searchable(),
                        ])->space(1),

                        Stack::make([
                            Split::make([
                                BadgeColumn::make('delivery_status')
                                    ->colors(config('panel.colors.delivery_status'))
                                    ->getStateUsing(function (Model $record): String {
                                        return  __('global.delivery_status.' . $record->delivery_status);
                                    }),
                                BadgeColumn::make('payment_status')
                                    ->colors(config('panel.colors.payment_status'))
                                    ->getStateUsing(function (Model $record): String {
                                        return  __('global.payment_status.' . $record->payment_status);
                                    }),
                            ]),
                        ]),
                        Split::make([
                            BadgeColumn::make('payment_type')
                                ->colors(['primary'])
                                ->getStateUsing(function (Model $record): String {
                                    return  __('global.payment_type.' . $record->payment_type);
                                }),
                            BadgeColumn::make('playlist_status')
                                ->colors(config('panel.colors.playlist_status'))
                                ->getStateUsing(function (Model $record): String {
                                    return $record->playlist_status ? __('global.playlist_status.' . $record->playlist_status) : '';
                                }),
                        ]),
                    ])->space(2),
                    Stack::make([
                        Stack::make([
                            TextColumn::make('country.name'),
                            BadgeColumn::make('deposit')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return $record->deposit_amount ? __('cruds.order.fields.deposit') . ' ' . currency_formatting($record->deposit_amount) : '';
                            }),
                            BadgeColumn::make('country.cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.order.fields.shipping') . ' ' . currency_formatting($record->shipping_country_cost);
                            }),
                            BadgeColumn::make('discount')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return $record->discount ?  __('cruds.order.fields.discount') . ' %' . $record->discount : '';
                            }),
                            BadgeColumn::make('total_cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.order.fields.total') . ' ' . currency_formatting($record->total_cost);
                            }),
                            BadgeColumn::make('total')->colors([
                                'success',
                            ])->getStateUsing(function (Model $record): String {
                                return '= ' . currency_formatting($record->calc_total());
                            }),
                        ])->space(1),
                        Split::make([
                            BadgeColumn::make('calling')
                                ->colors(['primary'])
                                ->getStateUsing(function (): String {
                                    return __('cruds.order.fields.calling');
                                }),
                            IconColumn::make('calling')->boolean()
                                ->toggle(),
                        ]),
                    ])->space(3),
                ]),
                Panel::make([
                    Stack::make([
                        TextColumn::make('shipping_address')->searchable(),
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('created_at')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.order.fields.created_at');
                                    }),
                                TextColumn::make('created_at')->dateTime(config('panel.date_format')),
                            ]),
                            Stack::make([
                                BadgeColumn::make('date_of_receiving_order')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.order.fields.date_of_receiving_order');
                                    }),
                                TextColumn::make('date_of_receiving_order')->dateTime(config('panel.date_format')),
                            ]),
                        ]),
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('excepected_deliverd_date')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.order.fields.excepected_deliverd_date');
                                    }),
                                TextColumn::make('excepected_deliverd_date')->dateTime(config('panel.date_format')),
                            ]),
                            Stack::make([
                                BadgeColumn::make('discount_code')->colors([
                                    'secondary',
                                ])->getStateUsing(function (Model $record): String {
                                    return $record->discount ? __('cruds.order.fields.discount_code') : '';
                                }),
                                TextColumn::make('discount_code'),
                            ]),
                        ]),
                    ])->space(3),
                ])->collapsible(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('user')->label(__('cruds.order.fields.user'))->relationship('user', 'name'),
                SelectFilter::make('delivery_status')->label(__('cruds.order.fields.delivery_status'))
                    ->options(__('global.delivery_status')),
                SelectFilter::make('playlist_status')->label(__('cruds.receipt_social.fields.playlist_status'))
                    ->options(__('global.playlist_status')),
                SelectFilter::make('payment_status')->label(__('cruds.order.fields.payment_status'))
                    ->options(__('global.payment_status')),
                TernaryFilter::make('calling')->label(__('cruds.order.fields.calling')),
                SelectFilter::make('order_type')->label(__('cruds.order.fields.order_type'))
                    ->options(\App\Models\Order::ORDER_TYPE_SELECT),
                Filter::make('phone_number')
                    ->form([
                        Forms\Components\TextInput::make('phone')->label(__('cruds.order.fields.phone')),
                    ])->query(function (Builder $query, array $data): Builder {
                        global $phone;
                        $phone = $data['phone'];
                        if ($phone) {
                            return $query->where(function ($q) {
                                $q->where('phone_number', 'like', '%' . $GLOBALS['phone'] . '%')
                                    ->orWhere('phone_number2', 'like', '%' . $GLOBALS['phone'] . '%');
                            });
                        } else {
                            return $query;
                        }
                    }),
                SelectFilter::make('shipping_country_id')->label(__('cruds.order.fields.shipping_country_name'))
                    ->options(session('countries')->pluck('naming', 'id')),
                Filter::make('date')->label('')
                    ->form([
                        Fieldset::make('Date')
                            ->schema([
                                Forms\Components\Select::make('date')->label(__('cruds.order.fields.date'))->options(['send_to_playlist_date' => 'تاريخ المرحلة','created_at' => 'تاريخ الأضافة']),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ActionGroup::make([
                    Action::make('playlist')
                    ->label(__('global.buttons.edit_playlist'))
                    ->icon('heroicon-s-menu-alt-1')
                    ->color('danger')
                    ->modalButton(__('global.buttons.edit'))
                    ->action(function (Order $record, array $data): void {
                        $status = $record->playlist_status;

                        $record->designer_id = $data['designer_id'];
                        $record->preparer_id = $data['preparer_id'];
                        $record->manufacturer_id = $data['manufacturer_id'];
                        $record->send_to_delivery_id = $data['send_to_delivery_id'];
                        if($status == 'pending'){
                            $record->send_to_playlist_date = date('Y-m-d H:i:s');
                        }
                        $record->playlist_status = $status == 'pending' ?  'design' : $record->playlist_status;
                        $record->save();

                        if($status == 'pending'){
                            $title = 'فاتورة جديدة';
                            $body = $record->order_num;
                            $user = User::find($data['designer_id']);
                            if($user){
                                Notification::make()
                                    ->title($title . ' ' . $body)
                                    ->success()
                                    ->sendToDatabase($user)
                                    ->send();
                            }
                        }

                        Notification::make()
                            ->title(__('global.notifications.edited'))
                            ->success()
                            ->send();

                    })
                    ->mountUsing(function (Order $record,Forms\ComponentContainer $form){
                        $general_setting = GeneralSetting::first();

                        return $form->fill([
                            'designer_id' => $record->designer_id ? $record->designer_id : $general_setting->designer_id,
                            'preparer_id' => $record->preparer_id ? $record->preparer_id : $general_setting->preparer_id,
                            'manufacturer_id' => $record->manufacturer_id ? $record->manufacturer_id : $general_setting->manufacturer_id,
                            'send_to_delivery_id' => $record->send_to_delivery_id ? $record->send_to_delivery_id : $general_setting->send_to_delivery_id,
                        ]);
                    })
                    ->form([
                        Card::make()
                            ->schema([
                                Select::make('designer_id')
                                    ->label(__('cruds.playlist.design'))
                                    ->options(session('playlist_users')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                                Select::make('preparer_id')
                                    ->label(__('cruds.playlist.manufacturing'))
                                    ->options(session('playlist_users')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                                Select::make('manufacturer_id')
                                    ->label(__('cruds.playlist.prepare'))
                                    ->options(session('playlist_users')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                                Select::make('send_to_delivery_id')
                                    ->label(__('cruds.playlist.send_to_delivery'))
                                    ->options(session('playlist_users')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable(),
                            ])->columns(2),
                    ]),
                ])
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
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
