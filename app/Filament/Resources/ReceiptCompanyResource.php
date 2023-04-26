<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptCompanyResource\Pages;
use App\Filament\Resources\ReceiptCompanyResource\RelationManagers;
use App\Models\GeneralSetting;
use App\Models\ReceiptCompany;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptCompanyResource extends Resource
{
    protected static ?string $model = ReceiptCompany::class;

    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('cruds.receipt_company.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.receipt_company.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.receipt_company.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.receipt_company.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Client Info')
                    ->label(__('cruds.receipt_company.fieldset.client_info'))
                    ->schema([

                        DatePicker::make('date_of_receiving_order')
                                ->label(__('cruds.receipt_company.fields.date_of_receiving_order'))
                                ->columnSpan('full'),
                        TextInput::make('client_name')
                                ->required()
                                ->label(__('cruds.receipt_company.fields.client_name')),
                        Select::make('type')
                                ->required()
                                ->label(__('cruds.receipt_company.fields.type'))
                                ->options([
                                    'individual' => 'Individual',
                                    'corporate' => 'Corporate'
                                ]),
                        TextInput::make('phone_number')
                                ->required()
                                ->label(__('cruds.receipt_company.fields.phone_number'))
                                ->regex('/(01)[0-9]{9}/'),
                        TextInput::make('phone_number2')
                                ->label(__('cruds.receipt_company.fields.phone_number2'))
                                ->regex('/(01)[0-9]{9}/'),

                    ])->columnSpan('lg'),

                Fieldset::make('Shipping Address')
                    ->label(__('cruds.receipt_company.fieldset.shipping_address'))
                    ->schema([

                        DatePicker::make('deliver_date')
                                ->label(__('cruds.receipt_company.fields.deliver_date')),
                        Select::make('country_id')
                                ->required()
                                ->label(__('cruds.receipt_company.fields.shipping_country_name'))
                                ->options(session('countries')->pluck('naming', 'id'))
                                ->relationship('country', 'name')
                                ->searchable(),
                        Textarea::make('shipping_address')
                                ->required()
                                ->label(__('cruds.receipt_company.fields.shipping_address'))
                                ->columnSpan('full'),

                    ])->columnSpan('lg'),

                Fieldset::make('Receipt Info')
                    ->label(__('cruds.receipt_company.fieldset.receipt_info'))
                    ->schema([

                        TextInput::make('total_cost')
                            ->required()
                            ->numeric()
                            ->label(__('cruds.receipt_company.fields.total_cost')),
                        TextInput::make('deposit')
                            ->numeric()
                            ->label(__('cruds.receipt_company.fields.deposit')),
                        FileUpload::make('photos')
                            ->label(__('cruds.receipt_company.fields.photos'))
                            ->directory('uploads/receipt_comapny/photos')
                            ->multiple()
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(5)
                            ->image()
                            ->imagePreviewHeight('100')
                            ->enableReordering(),
                        RichEditor::make('description')
                            ->label(__('cruds.receipt_company.fields.description'))
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ]),
                        TextArea::make('note')
                                ->label(__('cruds.receipt_company.fields.note')),
                    ])
            ])->columns(2);
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
                            TextColumn::make('phone_number2')->searchable(),
                        ])->space(1),
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('quickly')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_company.fields.quickly');
                                    }),
                                IconColumn::make('quickly')->boolean()
                                ->toggle(),
                            ]),
                            Stack::make([
                                BadgeColumn::make('done')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_company.fields.done');
                                    }),
                                IconColumn::make('done')
                                            ->boolean()
                                            ->toggle()
                            ]),
                        ]),
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('calling')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_company.fields.calling');
                                    }),
                                IconColumn::make('calling')->boolean()
                                ->toggle(),
                            ])->space(1),
                            Stack::make([
                                BadgeColumn::make('no_answer')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_company.fields.no_answer');
                                    }),
                                IconColumn::make('no_answer')->boolean()
                                ->toggle(),
                            ]),
                        ]),
                    ])->space(2),
                    Stack::make([
                        Stack::make([
                            TextColumn::make('country.name'),
                            BadgeColumn::make('deposit')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return $record->deposit ? __('cruds.receipt_company.fields.deposit') . ' ' . currency_formatting($record->deposit) : "";
                            }),
                            BadgeColumn::make('country.cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.receipt_company.fields.shipping_country_name') . ' ' . currency_formatting($record->shipping_country_cost);
                            }),
                            BadgeColumn::make('total_cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.receipt_company.fields.total_cost') . ' ' . currency_formatting($record->total_cost);
                            }),
                            BadgeColumn::make('total')->colors([
                                'success',
                            ])->getStateUsing(function (Model $record): String {
                                return '= ' . currency_formatting($record->calc_total());
                            }),
                        ])->space(1),

                        Stack::make([
                            Split::make([
                                BadgeColumn::make('delivery_status')
                                    ->colors(config('panel.colors.delivery_status'))
                                    ->getStateUsing(function (Model $record): String {
                                        return  __('global.delivery_status.' . $record->delivery_status);
                                    }),
                                // BadgeColumn::make('payment_status')
                                //     ->colors([
                                //         'success' => 'paid',
                                //         'secondary' => 'un_paid',
                                //     ]),
                                BadgeColumn::make('playlist_status')
                                    ->colors(config('panel.colors.playlist_status'))
                                    ->getStateUsing(function (Model $record): String {
                                        return $record->playlist_status ? __('global.playlist_status.' . $record->playlist_status) : '';
                                    }),
                            ]),
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
                                        return __('cruds.receipt_company.fields.created_at');
                                    }),
                                TextColumn::make('created_at')->dateTime(config('panel.date_format')),
                            ]),
                            Stack::make([
                                BadgeColumn::make('date_of_receiving_order')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_company.fields.date_of_receiving_order');
                                    }),
                                TextColumn::make('date_of_receiving_order')->dateTime(config('panel.date_format')),
                            ]),
                        ]),
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('send_to_playlist_date')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.playlist.send_to_playlist_date');
                                    }),
                                TextColumn::make('send_to_playlist_date')->dateTime(config('panel.date_format')),
                            ]),
                            BadgeColumn::make('type')
                                ->enum(ReceiptCompany::TYPE_SELECT)
                                ->colors(['primary']),
                        ]),
                        Stack::make([
                            BadgeColumn::make('description')->colors([
                                'primary',
                            ])->getStateUsing(function (): String {
                                return __('cruds.receipt_company.fields.description');
                            }),
                            TextColumn::make('description')->html()->searchable(),
                        ]),
                        Stack::make([
                            BadgeColumn::make('note')->colors([
                                'success',
                            ])->getStateUsing(function (): String {
                                return __('cruds.receipt_company.fields.note');
                            }),
                            TextColumn::make('note')->searchable(),
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
                            ->label(__('cruds.receipt_company.fields.staff_id'))
                            ->relationship('staff', 'name'),
                SelectFilter::make('delivery_status')
                            ->label(__('cruds.receipt_company.fields.delivery_status'))
                            ->options(__('global.delivery_status')),
                SelectFilter::make('playlist_status')->label(__('cruds.receipt_social.fields.playlist_status'))
                    ->options(__('global.playlist_status')),
                SelectFilter::make('payment_status')
                            ->label(__('cruds.receipt_company.fields.payment_status'))
                            ->options(__('global.playlist_status')),
                TernaryFilter::make('done')
                            ->label(__('cruds.receipt_company.fields.done')),
                SelectFilter::make('type')
                            ->label(__('cruds.receipt_company.fields.type'))
                            ->options(\App\Models\ReceiptSocial::TYPE_SELECT),
                TernaryFilter::make('quickly')
                            ->label(__('cruds.receipt_company.fields.quickly')),
                Filter::make('phone_number')
                    ->form([
                        Forms\Components\TextInput::make('phone')
                                    ->label(__('cruds.receipt_company.fields.phone')),
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
                SelectFilter::make('shipping_country_id')
                            ->label(__('cruds.receipt_company.fields.shipping_country_name'))
                    ->options(session('countries')->pluck('naming', 'id')),
                Filter::make('date')
                    ->form([
                        Fieldset::make('Date')->label('')
                            ->schema([
                                Forms\Components\Select::make('date')
                                ->label(__('cruds.receipt_company.fields.date'))
                                ->options(['send_to_playlist_date' => 'تاريخ المرحلة', 'created_at' => 'تاريخ الأضافة']),
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
                Filter::make('order_num')
                    ->form([
                        Fieldset::make('Order Num')->label(__('global.order_num'))
                            ->schema([
                                Forms\Components\Select::make('order_from')->label(__('global.order_from'))
                                    ->options(session('receipt_socials')->pluck('order_num', 'id'))
                                    ->searchable(),
                                Forms\Components\Select::make('order_to')->label(__('global.order_to'))
                                    ->options(session('receipt_socials')->pluck('order_num', 'id'))
                                    ->searchable(),
                                Forms\Components\Select::make('order_exclude')->label(__('global.order_exclude'))
                                    ->options(session('receipt_socials')->pluck('order_num', 'id'))
                                    ->searchable()
                                    ->multiple(),
                                Forms\Components\Select::make('order_include')->label(__('global.order_include'))
                                    ->options(session('receipt_socials')->pluck('order_num', 'id'))
                                    ->searchable()
                                    ->multiple(),
                            ])->columns(1)
                    ])->query(function (Builder $query, array $data): Builder {
                        if ($data['order_from'] && $data['order_to'])
                            $query = $query->whereBetween('id', [$data['order_from'], $data['order_to']]);

                        if ($data['order_exclude'])
                            $query = $query->whereNotIn('id', $data['order_exclude']);

                        if ($data['order_include'])
                            $query = $query->orWhereIn('id', $data['order_include']);

                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-s-duplicate')
                    ->label(__('global.buttons.duplicate'))
                    ->color('warning')
                    ->action(function (ReceiptCompany $record) {
                        $new_receipt = $record->replicate();
                        $last_receipt_company = ReceiptCompany::withTrashed()->latest()->first();
                        if($last_receipt_company){
                            $order_num = $last_receipt_company->order_num ? intval(str_replace('#','',strrchr($last_receipt_company->order_num,"#"))) : 0;
                        }else{
                            $order_num = 0;
                        }

                        $new_receipt->staff_id = auth()->user()->id;
                        $new_receipt->order_num =  'receipt-company#' . ($order_num + 1);
                        $new_receipt->printing_times = 0;
                        $new_receipt->save();
                    }),
                Tables\Actions\ActionGroup::make([
                    Action::make('playlist')
                    ->label(__('global.buttons.edit_playlist'))
                    ->icon('heroicon-s-menu-alt-1')
                    ->color('danger')
                    ->modalButton(__('global.buttons.edit'))
                    ->action(function (ReceiptCompany $record, array $data): void {
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
                    ->mountUsing(function (ReceiptCompany $record,Forms\ComponentContainer $form){
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
                Tables\Actions\BulkAction::make('print')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_company.actions',['ids' => $records->pluck('id'),'action' => 'print']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-printer'),
                Tables\Actions\BulkAction::make('download')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_company.actions',['ids' => $records->pluck('id'),'action' => 'download']))
                    ->requiresConfirmation()
                    ->color('primary')
                    ->icon('heroicon-o-download'),
                Tables\Actions\BulkAction::make('stats')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_company.actions',['ids' => $records->pluck('id'),'action' => 'stats']))
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
            'index' => Pages\ListReceiptCompanies::route('/'),
            'create' => Pages\CreateReceiptCompany::route('/create'),
            'edit' => Pages\EditReceiptCompany::route('/{record}/edit'),
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
