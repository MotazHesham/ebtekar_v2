<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Attribute;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('cruds.product.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.product.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.product.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.product.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('fields')->tabs([
                    Tab::make('Product Information')->label(__('cruds.product.tabs.product_information'))->schema([
                        TextInput::make('name')
                            ->label(__('cruds.product.fields.name'))
                            ->required(),

                        Select::make('category_id')
                            ->label(__('cruds.product.fields.category'))
                            ->options(Category::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(function (callable $set) {
                                $set('subcategory_id', null);
                                $set('subsubcategory_id', null);
                            }),

                        Select::make('subcategory_id')
                            ->label(__('cruds.product.fields.subcategory'))
                            ->options(function (callable $get) {
                                $category = Category::find($get('category_id'));
                                if (!$category) {
                                    return SubCategory::all()->pluck('name', 'id');
                                }
                                return $category->subcategories->pluck('name', 'id');
                            })
                            ->searchable()
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(fn (callable $set) => $set('subsubcategory_id', null)),

                        Select::make('subsubcategory_id')
                            ->label(__('cruds.product.fields.subsubcategory'))
                            ->options(function (callable $get) {
                                $subcategory = SubCategory::find($get('subcategory_id'));
                                if (!$subcategory) {
                                    return SubSubCategory::all()->pluck('name', 'id');
                                }
                                return $subcategory->subsubcategories->pluck('name', 'id');
                            })
                            ->searchable(),

                        Select::make('brand_id')
                            ->label(__('cruds.product.fields.brand'))
                            ->options(Brand::all()->pluck('name', 'id'))
                            ->searchable(),

                        TextInput::make('unit')
                            ->label(__('cruds.product.fields.unit'))->numeric(),
                        TagsInput::make('tags')
                            ->label(__('cruds.product.fields.tags')),
                    ])->columns(3),

                    Tab::make('Images')->label(__('cruds.product.tabs.images'))->schema([
                        FileUpload::make('photos')
                            ->label(__('cruds.product.fields.photos'))
                            ->directory('uploads/products/photos')
                            ->multiple()
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(8)
                            ->image()
                            ->imageCropAspectRatio('8:10')
                            ->imageResizeTargetWidth('1080')
                            ->imageResizeTargetHeight('1920')
                            ->imagePreviewHeight('100')
                            ->enableReordering()
                            ->required(),
                    ]),

                    Tab::make('Videos')->label(__('cruds.product.tabs.videos'))->schema([
                        Select::make('video_provider')
                            ->label(__('cruds.product.fields.video_provider'))
                            ->requiredWith('video_link')
                            ->options([
                                'youtube' => 'Youtube',
                                'dailymotion' => 'Dailymotion',
                                'vimeo' => 'Vimeo',
                            ]),
                        TextInput::make('video_link')
                            ->label(__('cruds.product.fields.video_link')),
                    ]),

                    Tab::make('Pricing')->label(__('cruds.product.tabs.pricing'))->schema([
                        TextInput::make('unit_price')
                            ->label(__('cruds.product.fields.unit_price'))
                            ->numeric()
                            ->required(),
                        TextInput::make('purchase_price')
                            ->label(__('cruds.product.fields.purchase_price'))
                            ->numeric()
                            ->required()
                        // ->reactive()
                        // ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        //     for ($item = 0; $item < count($get('product_stock')); $item++) {
                        //         $set('product_stock.' . $item . '.purchase_price', $state);
                        //     }
                        // })
                        ,
                        TextInput::make('discount')
                            ->label(__('cruds.product.fields.discount'))
                            ->numeric(),
                        Select::make('discount_type')
                            ->label(__('cruds.product.fields.discount_type'))
                            ->requiredWith('discount')
                            ->options([
                                'flat' => 'Flat',
                                'percent' => 'Percent',
                            ]),
                    ])->columns(2),

                    Tab::make('Attributes')->label(__('cruds.product.tabs.attributes'))->icon('heroicon-o-bell')->schema([
                        Select::make('colors')
                            ->label(__('cruds.product.fields.colors'))
                            ->multiple()
                            ->options(Color::all()->pluck('name', 'name'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                product_stock_maker($set, $get, '');
                            }),
                        Select::make('attributes')
                            ->label(__('cruds.product.fields.attributes'))
                            ->multiple()
                            ->options(Attribute::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $set('choice_options', null);
                                $attributes = $state;
                                for ($i = 0; $i < count($attributes); $i++) {
                                    $set('choice_options.' . $i . '.name', Attribute::find($attributes[$i])->name);
                                    $set('choice_options.' . $i . '.tag.0', null);
                                }
                                product_stock_maker($set, $get, '');
                            }),
                        TableRepeater::make('choice_options')
                            ->label(__('cruds.product.fields.choice_options'))
                            ->schema([
                                TextInput::make('name')
                                    ->disableLabel()
                                    ->disabled(),
                                TagsInput::make('tag')
                                    ->disableLabel()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        product_stock_maker($set, $get, '../../');
                                    }),
                            ])
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->defaultItems(0),
                        TableRepeater::make('product_stock')
                                    ->label(__('cruds.product.fields.product_stock'))
                            ->relationship()
                            ->schema([
                                TextInput::make('variant')
                                    ->disableLabel()
                                    ->disabled(),
                                TextInput::make('unit_price')
                                    ->disableLabel()
                                    ->numeric()
                                    ->requiredWith('variant'),
                                TextInput::make('purchase_price')
                                    ->disableLabel()
                                    ->numeric()
                                    ->requiredWith('variant'),
                                TextInput::make('quantity')
                                    ->disableLabel()
                                    ->numeric()
                                    ->requiredWith('variant'),
                            ])
                            ->columnSpan('full')
                            ->defaultItems(0)
                            ->disableItemCreation(),
                    ])->columns(3),

                    Tab::make('Description')->label(__('cruds.product.tabs.description'))->schema([
                        RichEditor::make('description')
                            ->label(__('cruds.product.fields.description'))
                            ->disableToolbarButtons([
                                'attachFiles',
                                'codeBlock',
                            ]),
                        FileUpload::make('pdf')
                            ->label(__('cruds.product.fields.pdf'))
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('uploads/products/pdf')
                            ->enableOpen(),
                    ]),

                    Tab::make('SEO Meta Tags')->label(__('cruds.product.tabs.seo'))->schema([
                        TextInput::make('meta_title')
                        ->label(__('cruds.product.fields.meta_title')),
                        Textarea::make('meta_description')
                        ->label(__('cruds.product.fields.meta_description')),
                    ]),

                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                            ->label(__('cruds.product.fields.name'))->searchable(),
                ViewColumn::make('photos')
                            ->label(__('cruds.product.fields.photos'))->view('filament.tables.columns.photos'),
                TextColumn::make('current_stock')
                            ->label(__('cruds.product.fields.current_stock'))->sortable(),
                TextColumn::make('unit_price')
                            ->label(__('cruds.product.fields.unit_price'))->sortable(),
                IconColumn::make('published')
                            ->label(__('cruds.product.fields.published'))->toggle()->boolean(),
                IconColumn::make('featured')
                            ->label(__('cruds.product.fields.featured'))->toggle()->boolean(),
                IconColumn::make('todays_deal')
                            ->label(__('cruds.product.fields.todays_deal'))->toggle()->boolean(),
                IconColumn::make('flash_deal')
                            ->label(__('cruds.product.fields.flash_deal'))->toggle()->boolean(),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                TernaryFilter::make('published')
                            ->label(__('cruds.product.fields.published')),
                TernaryFilter::make('featured')
                            ->label(__('cruds.product.fields.featured')),
                TernaryFilter::make('todays_deal')
                            ->label(__('cruds.product.fields.todays_deal')),
                TernaryFilter::make('flash_deal')
                            ->label(__('cruds.product.fields.flash_deal')),
                // TernaryFilter::make('special')
                //             ->label(__('cruds.product.fields.special')),
                Filter::make('categories')
                    ->form([
                        Select::make('category_id')
                            ->label(__('cruds.product.fields.category'))
                            ->options(Category::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('subcategory_id', null);
                                $set('subsubcategory_id', null);
                            }),

                        Select::make('subcategory_id')
                            ->label(__('cruds.product.fields.subcategory'))
                            ->options(function (callable $get) {
                                $category = Category::find($get('category_id'));
                                if (!$category) {
                                    return SubCategory::all()->pluck('name', 'id');
                                }
                                return $category->subcategories->pluck('name', 'id');
                            })
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('subsubcategory_id', null)),

                        Select::make('subsubcategory_id')
                            ->label(__('cruds.product.fields.subsubcategory'))
                            ->options(function (callable $get) {
                                $subcategory = SubCategory::find($get('subcategory_id'));
                                if (!$subcategory) {
                                    return SubSubCategory::all()->pluck('name', 'id');
                                }
                                return $subcategory->subsubcategories->pluck('name', 'id');
                            })
                            ->searchable(),
                    ])
                    ->indicateUsing(function (array $data){
                        $indicators = [];

                        if ($data['category_id'] ?? null) {
                            $indicators['category_id'] = Category::find($data['category_id'])->name;
                        }
                        if ($data['subcategory_id'] ?? null) {
                            $indicators['subcategory_id'] = SubCategory::find($data['subcategory_id'])->name;
                        }
                        if ($data['subsubcategory_id'] ?? null) {
                            $indicators['subsubcategory_id'] = SubSubCategory::find($data['subsubcategory_id'])->name;
                        }

                        return $indicators;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['category_id'] != null) {
                            $query->where('category_id', $data['category_id']);
                        }
                        if ($data['subcategory_id'] != null) {
                            $query->where('subcategory_id', $data['subcategory_id']);
                        }
                        if ($data['subsubcategory_id'] != null) {
                            $query->where('subsubcategory_id', $data['subsubcategory_id']);
                        }
                        return $query;
                    })
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Tables\Actions\Action::make('duplicate')
                        ->icon('heroicon-s-duplicate')
                        ->label(__('global.buttons.duplicate'))
                        ->color('warning')
                        ->action(function (Product $record) {
                            $new_product = $record->replicate();
                            $new_product->slug = substr($new_product->slug, 0, -5) . Str::random(5);
                            if ($new_product->save()) {
                                foreach ($record->product_stock as $stk) {
                                    $stk->replicate();
                                    $stk->product_id = $new_product->id;
                                    $stk->save();
                                };
                            }
                        }),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
