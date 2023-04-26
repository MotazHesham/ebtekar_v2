<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptClientResource\Pages;
use App\Filament\Resources\ReceiptClientResource\RelationManagers;
use App\Models\ReceiptClient;
use App\Models\ReceiptClientProduct;
use App\Models\ReceiptProduct;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\ViewField;
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

class ReceiptClientResource extends Resource
{
    protected static ?string $model = ReceiptClient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('cruds.receipt_client.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.receipt_client.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.receipt_client.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.receipt_client.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date_of_receiving_order')
                            ->label(__('cruds.receipt_client.fields.date_of_receiving_order'))
                            ->columnSpan('full'),
                TextInput::make('client_name')
                            ->label(__('cruds.receipt_client.fields.client_name'))
                            ->required(),
                TextInput::make('phone_number')
                            ->label(__('cruds.receipt_client.fields.phone_number'))
                            ->regex('/(01)[0-9]{9}/')
                            ->required(),
                TextInput::make('deposit')
                            ->numeric()
                            ->label(__('cruds.receipt_client.fields.deposit')),
                TextInput::make('discount')
                            ->numeric()
                            ->label(__('cruds.receipt_client.fields.discount')),
                RichEditor::make('note')
                            ->label(__('cruds.receipt_client.fields.note'))
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
                                IconColumn::make('done')
                                            ->boolean()
                                            ->toggle()
                            ]),
                        ]),
                    ])->space(2),
                    Stack::make([
                        Stack::make([
                            BadgeColumn::make('deposit')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return $record->deposit ? __('cruds.receipt_client.fields.deposit') . ' ' . currency_formatting($record->deposit) : '';
                            }),
                            BadgeColumn::make('discount')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return $record->discount ? __('cruds.receipt_client.fields.discount') . ' %' . $record->discount : '';
                            }),
                            BadgeColumn::make('total_cost')->colors([
                                'secondary',
                            ])->getStateUsing(function (Model $record): String {
                                return __('cruds.receipt_client.fields.total_cost') . ' ' . currency_formatting($record->total_cost);
                            }),
                            BadgeColumn::make('total')->colors([
                                'success',
                            ])->getStateUsing(function (Model $record): String {
                                return '= ' . currency_formatting($record->calc_total());
                            }),
                        ])->space(1),
                    ])->space(3),
                ]),
                Panel::make([
                    Stack::make([
                        Split::make([
                            Stack::make([
                                BadgeColumn::make('created_at')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_client.fields.created_at');
                                    }),
                                TextColumn::make('created_at')->dateTime(config('panel.date_format')),
                            ]),
                            Stack::make([
                                BadgeColumn::make('date_of_receiving_order')
                                    ->colors(['danger'])
                                    ->getStateUsing(function (): String {
                                        return __('cruds.receipt_client.fields.date_of_receiving_order');
                                    }),
                                TextColumn::make('date_of_receiving_order')->dateTime(config('panel.date_format')),
                            ]),
                        ]),
                        Stack::make([
                            BadgeColumn::make('note')->colors([
                                'success',
                            ])->getStateUsing(function (): String {
                                return __('cruds.receipt_client.fields.note');
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
                    ->label(__('cruds.receipt_client.fields.staff_id'))->relationship('staff', 'name'),
                TernaryFilter::make('done')
                    ->label(__('cruds.receipt_client.fields.done')),
                TernaryFilter::make('quickly')
                    ->label(__('cruds.receipt_client.fields.quickly')),
                Filter::make('date')
                    ->label(__('cruds.receipt_client.fields.date'))
                    ->form([
                        Fieldset::make('Date')->label('')
                            ->schema([
                                Forms\Components\Select::make('date')->label(__('cruds.receipt_client.fields.date'))->options([ 'created_at' => 'تاريخ الأضافة']),
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

                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-s-duplicate')
                    ->label(__('global.buttons.duplicate'))
                    ->color('warning')
                    ->action(function (ReceiptClient $record) {
                        $new_receipt = $record->replicate();
                        $last_receipt_client = ReceiptClient::withTrashed()->latest()->first();
                        if($last_receipt_client){
                            $order_num = $last_receipt_client->order_num ? intval(str_replace('#','',strrchr($last_receipt_client->order_num,"#"))) : 0;
                        }else{
                            $order_num = 0;
                        }

                        $new_receipt->staff_id = auth()->user()->id;
                        $new_receipt->order_num =  'receipt-client#' . ($order_num + 1);
                        $new_receipt->printing_times = 0;
                        $new_receipt->save();

                        $receipt_products = ReceiptClientProduct::where('receipt_client_id',$record->id)->get();

                        foreach($receipt_products as $row){
                            $new_receipt_product = $row->replicate();
                            $new_receipt_product->receipt_client_id = $new_receipt->id;
                            $new_receipt_product->save();
                        }
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Action::make('addProduct')
                        ->label(__('global.buttons.add_product'))
                        ->icon('heroicon-s-plus-circle')
                        ->modalButton(__('global.buttons.add'))
                        ->color('success')
                        ->action(function (ReceiptClient $record, array $data): void {

                            $product = ReceiptProduct::findOrFail($data['product_id']);

                            $receipt = new ReceiptClientProduct();
                            $receipt->receipt_client_id = $record->id;
                            $receipt->description = $product->name;
                            $receipt->cost = $product->price;
                            $receipt->quantity = $data['quantity'];
                            $receipt->total = ($data['quantity'] * $product->price);
                            $receipt->receipt_product_id = $data['product_id'];
                            $receipt->save();

                            $receipt_products = ReceiptClientProduct::where('receipt_client_id', $record->id)->get();
                            $sum = 0;
                            foreach ($receipt_products as $row) {
                                $sum += $row->total;
                            }
                            $record->total_cost = $sum;
                            $record->save();
                        })
                        ->form([
                            Grid::make(1)->schema([
                                Fieldset::make('Product')
                                    ->label('')
                                    ->schema([
                                        Select::make('product_id')
                                        ->label(__('cruds.receipt_client.products.product_name'))
                                            ->options(session('receipt_client_products')->pluck('name', 'id'))
                                            ->required()
                                            ->searchable() ,
                                        TextInput::make('quantity')
                                            ->label(__('cruds.receipt_client.products.quantity'))
                                            ->required()->numeric(),
                                    ])->columns(2),
                            ])
                        ]),
                    Action::make('viewProducts')
                        ->slideOver()
                        ->label(__('global.buttons.view_products'))
                        ->icon('heroicon-s-cube')
                        ->action(fn () => null)
                        ->form([
                            ViewField::make('Products')->view('receipts.client.products')
                        ]),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\BulkAction::make('print')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_client.actions',['ids' => $records->pluck('id'),'action' => 'print']))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-printer'),
                Tables\Actions\BulkAction::make('download')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_client.actions',['ids' => $records->pluck('id'),'action' => 'download']))
                    ->requiresConfirmation()
                    ->color('primary')
                    ->icon('heroicon-o-download'),
                Tables\Actions\BulkAction::make('stats')
                    ->action(fn (Collection $records) => redirect()->route('admin.receipt_client.actions',['ids' => $records->pluck('id'),'action' => 'stats']))
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
            'index' => Pages\ListReceiptClients::route('/'),
            'create' => Pages\CreateReceiptClient::route('/create'),
            'edit' => Pages\EditReceiptClient::route('/{record}/edit'),
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
