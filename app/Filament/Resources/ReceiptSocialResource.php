<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptSocialResource\Pages;
use App\Models\GeneralSetting;
use App\Models\ReceiptProduct;
use App\Models\ReceiptSocial;
use App\Models\ReceiptSocialProduct;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class ReceiptSocialResource extends Resource
{
    protected static ?string $model = ReceiptSocial::class;

    protected static ?string $navigationIcon = 'heroicon-o-status-online';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('cruds.receipt_social.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.receipt_social.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.receipt_social.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.receipt_social.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Client Info')
                    ->label(__('cruds.receipt_social.fieldset.client_info'))
                    ->schema([
                        DatePicker::make('date_of_receiving_order')
                            ->label(__('cruds.receipt_social.fields.date_of_receiving_order'))
                            ->columnSpan('full'),
                        TextInput::make('client_name')
                            ->label(__('cruds.receipt_social.fields.client_name'))
                            ->required(),
                        Select::make('type')
                            ->label(__('cruds.receipt_social.fields.type'))
                            ->searchable()
                            ->required()
                            ->options([
                                'individual' => 'Individual',
                                'corporate' => 'Corporate'
                            ]),
                        TextInput::make('phone_number')
                            ->regex('/(01)[0-9]{9}/')
                            ->required()
                            ->label(__('cruds.receipt_social.fields.phone_number')),
                        TextInput::make('phone_number2')
                            ->regex('/(01)[0-9]{9}/')
                            ->label(__('cruds.receipt_social.fields.phone_number2')),
                    ])->columnSpan('lg'),
                Fieldset::make('Shipping Address')
                    ->label(__('cruds.receipt_social.fieldset.shipping_address'))
                    ->schema([
                        DatePicker::make('deliver_date')
                            ->label(__('cruds.receipt_social.fields.deliver_date')),
                        Select::make('country_id')
                            ->label(__('cruds.receipt_social.fields.shipping_country_id'))
                            ->options(session('countries')->pluck('naming', 'id'))
                            ->relationship('country', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextArea::make('shipping_address')
                            ->label(__('cruds.receipt_social.fields.shipping_address'))
                            ->required()
                            ->columnSpan('full'),
                    ])->columnSpan('lg'),
                Fieldset::make('Receipt Info')
                    ->label(__('cruds.receipt_social.fieldset.receipt_info'))
                    ->schema([
                        TextInput::make('deposit')
                            ->label(__('cruds.receipt_social.fields.deposit'))
                            ->numeric(),
                        Select::make('socials')
                            ->label(__('cruds.receipt_social.fields.socials'))
                            ->multiple()
                            ->relationship('socials', 'name')
                            ->preload(),
                        TextArea::make('note')
                            ->label(__('cruds.receipt_social.fields.note')),
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
                            ])->getStateUsing(function (Model $record): String {
                                return '<a href="http://www.google.com">' . $record->order_num . '</a>';
                            })->html()->searchable(),
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
                                        return __('cruds.receipt_social.fields.quickly');
                                    }),
                                IconColumn::make('quickly')->boolean()
                                    ->toggle(),
                            ]),
                            Stack::make([
                                BadgeColumn::make('done')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_social.fields.done');
                                    }),
                                IconColumn::make('done')->boolean()
                                    ->toggle(),
                            ]),
                        ]),
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('confirm')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_social.fields.confirm');
                                    }),
                                IconColumn::make('confirm')->boolean()
                                    ->toggle(),
                            ])->space(1),
                            Stack::make([
                                BadgeColumn::make('returned')
                                    ->colors(['primary'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_social.fields.returned');
                                    }),
                                IconColumn::make('returned')->boolean()
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
                                return $record->deposit ? __('cruds.receipt_social.fields.deposit') . ' ' . currency_formatting($record->deposit) : '';
                            }),
                            BadgeColumn::make('commission')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.receipt_social.fields.commission') . ' ' . currency_formatting($record->commission + $record->exta_commission);
                            }),
                            BadgeColumn::make('country.cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.receipt_social.fields.shipping') . ' ' . currency_formatting($record->shipping_country_cost);
                            }),
                            BadgeColumn::make('total_cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.receipt_social.fields.total') . ' ' . currency_formatting($record->total_cost);
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
                                //     ->colors(config('panel.colors.payment_status'))
                                //     ->getStateUsing(function (Model $record): String {
                                //         return  __('global.payment_status.' . $record->payment_status);
                                //     }),
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
                                        return __('cruds.receipt_social.fields.created_at');
                                    }),
                                TextColumn::make('created_at')->dateTime(config('panel.date_format')),
                            ]),
                            Stack::make([
                                BadgeColumn::make('date_of_receiving_order')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_social.fields.date_of_receiving_order');
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
                                ->enum(ReceiptSocial::TYPE_SELECT)
                                ->colors(['primary']),
                        ]),
                        Stack::make([
                            BadgeColumn::make('note')->colors([
                                'success',
                            ])->getStateUsing(function (): String {
                                return 'Note';
                            }),
                            TextColumn::make('note')->searchable(),
                        ]),
                        Split::make([
                            BadgeColumn::make('staff.name')->colors([
                                'success',
                            ]),
                            TagsColumn::make('socials.name')
                        ]),
                    ])->space(3),
                ])->collapsible(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('staff')->label(__('cruds.receipt_social.fields.staff_id'))->relationship('staff', 'name'),
                SelectFilter::make('delivery_status')->label(__('cruds.receipt_social.fields.delivery_status'))
                    ->options(__('global.delivery_status')),
                SelectFilter::make('playlist_status')->label(__('cruds.receipt_social.fields.playlist_status'))
                    ->options(__('global.playlist_status')),
                TernaryFilter::make('done')->label(__('cruds.receipt_social.fields.done')),
                SelectFilter::make('type')->label(__('cruds.receipt_social.fields.type'))
                    ->options(\App\Models\ReceiptSocial::TYPE_SELECT),
                TernaryFilter::make('quickly')->label(__('cruds.receipt_social.fields.quickly')),
                SelectFilter::make('shipping_country_id')->label(__('cruds.receipt_social.fields.shipping_country_id'))->searchable()
                    ->options(session('countries')->pluck('naming', 'id')),
                SelectFilter::make('socials')->label(__('cruds.receipt_social.fields.socials'))->multiple()->relationship('socials', 'name'),
                Filter::make('description')
                    ->form([
                        Forms\Components\TextInput::make('description')->label(__('cruds.receipt_social.fields.description')),
                    ])->query(function (Builder $query, array $data): Builder {
                        $description = $data['description'];
                        if ($description) {
                            return $query->whereHas('receipt_social_products', function ($query) use ($description) {
                                $query->where('description', 'like', '%' . $description . '%');
                            });
                        } else {
                            return $query;
                        }
                    }),
                Filter::make('date')
                    ->form([
                        Fieldset::make('Date')->label('')
                            ->schema([
                                Forms\Components\Select::make('date')->label(__('cruds.order.fields.date'))->options(['send_to_playlist_date' => 'تاريخ المرحلة', 'created_at' => 'تاريخ الأضافة']),
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

                Tables\Actions\ActionGroup::make([
                    Action::make('addProduct')
                        ->slideOver()
                        ->label(__('global.buttons.add_product'))
                        ->icon('heroicon-s-plus-circle')
                        ->color('success')
                        ->modalButton(__('global.buttons.add'))
                        ->action(function (ReceiptSocial $record, array $data): void {

                            $product = ReceiptProduct::findOrFail($data['product_id']);

                            $receipt = new ReceiptSocialProduct();
                            $receipt->receipt_social_id = $record->id;
                            $receipt->title = $product->name;
                            $receipt->receipt_product_id = $data['product_id'];
                            $receipt->description = $data['description'];
                            $receipt->cost = $product->price;
                            $receipt->commission = ($data['quantity'] *  $product->commission);
                            $receipt->quantity = $data['quantity'];
                            $receipt->total = ($data['quantity'] * $product->price);
                            $receipt->photos = json_encode($data['photos']);
                            $receipt->pdf = $data['pdf'];
                            $receipt->save();

                            $receipt_products = ReceiptSocialProduct::where('receipt_social_id', $record->id)->get();
                            $sum = 0;
                            $sum2 = 0;
                            $sum3 = 0;
                            foreach ($receipt_products as $row) {
                                $sum += $row->total;
                                $sum2 += $row->commission;
                                $sum3 += $row->extra_commission;
                            }
                            $record->total_cost = $sum;
                            $record->commission = $sum2;
                            $record->extra_commission = $sum3;
                            $record->save();

                            Notification::make()
                                ->title(__('global.notifications.product_added'))
                                ->success()
                                ->send();
                        })
                        ->form([
                            Grid::make(2)->schema([
                                Fieldset::make('Product')
                                    ->label(__('cruds.receipt_social.fieldset.product'))
                                    ->schema([
                                        Select::make('product_id')
                                            ->label(__('cruds.receipt_social.products.product_name'))
                                            ->options(session('receipt_social_products')->pluck('name', 'id'))
                                            ->required()
                                            ->searchable()
                                            ->columnSpan('full'),
                                        TextInput::make('quantity')
                                            ->label(__('cruds.receipt_social.products.quantity'))
                                            ->required()
                                            ->numeric()
                                            ->columnSpan('full'),
                                        FileUpload::make('pdf')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->directory('uploads/receipt_social/pdf')
                                            ->enableOpen()
                                            ->columnSpan('full'),
                                        RichEditor::make('description')
                                            ->label(__('cruds.receipt_social.products.description'))
                                            ->disableToolbarButtons([
                                                'attachFiles',
                                                'codeBlock',
                                            ])->columnSpan('full'),
                                    ])->columnSpan(1),
                                Repeater::make('photos')
                                    ->label(__('cruds.receipt_social.fieldset.photos'))
                                    ->schema([
                                        FileUpload::make('photo')
                                            ->label(__('cruds.receipt_social.products.images'))
                                            ->directory('uploads/receipt_social/photos')
                                            ->enableOpen()
                                            ->maxSize(2048)
                                            ->maxFiles(5)
                                            ->image()
                                            ->imagePreviewHeight('100')
                                            ->enableReordering(),
                                        TextInput::make('note')
                                            ->label(__('cruds.receipt_social.products.note'))
                                    ])
                                    ->createItemButtonLabel(__('global.buttons.add_more'))
                                    ->columns(2)
                            ])
                        ]),
                    Action::make('viewProducts')
                        ->slideOver()
                        ->label(__('global.buttons.view_products'))
                        ->icon('heroicon-s-cube')
                        ->action(fn () => null)
                        ->form([
                            ViewField::make('Products')->view('receipts.social.products')
                        ]),
                    Action::make('playlist')
                        ->label(__('global.buttons.edit_playlist'))
                        ->icon('heroicon-s-menu-alt-1')
                        ->color('danger')
                        ->modalButton(__('global.buttons.edit'))
                        ->action(function (ReceiptSocial $record, array $data): void {
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
                        ->mountUsing(function (ReceiptSocial $record,Forms\ComponentContainer $form){
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
                    Action::make('delivery_man')
                        ->label(__('global.buttons.delivery_man'))
                        ->icon('heroicon-s-truck')
                        ->color('warning')
                        ->modalButton(__('global.buttons.edit'))
                        ->action(function (ReceiptSocial $record, array $data): void {
                            $record->delivery_man_id = $data['delivery_man_id'];
                            $record->delivery_status = 'on_delivery';
                            $record->save();

                            Notification::make()
                                ->title(__('global.notifications.edited'))
                                ->success()
                                ->send();

                        })
                        ->mountUsing(function (ReceiptSocial $record,Forms\ComponentContainer $form){
                            return $form->fill([
                                'delivery_man_id' => $record->delivery_man_id,
                            ]);
                        })
                        ->form([
                            Card::make()
                                ->schema([
                                    Select::make('delivery_man_id')
                                        ->label(__('cruds.receipt_social.fields.delivery_man_id'))
                                        ->options(session('delivery_users')->pluck('name', 'id'))
                                        ->required()
                                        ->searchable(),
                                ])->columns(1),
                        ]),
                    Action::make('logs')
                        ->slideOver()
                        ->label(__('global.buttons.logs'))
                        ->icon('heroicon-s-document-text')
                        ->color('secondary')
                        ->action(fn () => null)
                        ->form([
                            ViewField::make('logs')->view('receipts.social.logs')
                        ]),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('stats')->label(__('global.stats'))
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_social.actions', ['ids' => $records->pluck('id'), 'action' => 'stats']))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-chart-bar'),
                Tables\Actions\BulkAction::make('print')->label(__('global.print'))
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_social.actions', ['ids' => $records->pluck('id'), 'action' => 'print']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-s-printer'),
                Tables\Actions\BulkAction::make('receive_money')->label(__('global.receive_money'))
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_social.actions', ['ids' => $records->pluck('id'), 'action' => 'receive_money']))
                    ->requiresConfirmation()
                    ->color('secondary')
                    ->icon('heroicon-o-printer'),
                Tables\Actions\BulkAction::make('download')->label(__('global.download'))
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_social.actions', ['ids' => $records->pluck('id'), 'action' => 'download']))
                    ->requiresConfirmation()
                    ->color('primary')
                    ->icon('heroicon-o-download'),
                Tables\Actions\BulkAction::make('download_for_delivery')->label(__('global.download_for_delivery'))
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_social.actions', ['ids' => $records->pluck('id'), 'action' => 'download_for_delivery']))
                    ->requiresConfirmation()
                    ->color('warning')
                    ->icon('heroicon-o-cloud-download'),
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
            'index' => Pages\ListReceiptSocials::route('/'),
            'create' => Pages\CreateReceiptSocial::route('/create'),
            'view' => Pages\ViewProducts::route('/{record}'),
            'edit' => Pages\EditReceiptSocial::route('/{record}/edit'),
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
