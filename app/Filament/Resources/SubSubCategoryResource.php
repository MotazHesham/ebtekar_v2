<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubSubCategoryResource\Pages;
use App\Filament\Resources\SubSubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class SubSubCategoryResource extends Resource
{
    protected static ?string $model = SubSubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-s-duplicate';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('cruds.subsubcategory.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.subsubcategory.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.subsubcategory.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.subsubcategory.navigation_group');

    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->label(__('cruds.subsubcategory.fields.name'))
                            ->required(),
                Select::make('sub_category_id')
                            ->label(__('cruds.subsubcategory.fields.subcategory'))
                            ->options(SubCategory::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                TextInput::make('meta_title')
                            ->label(__('cruds.subsubcategory.fields.meta_title')),
                TextArea::make('meta_description')
                            ->label(__('cruds.subsubcategory.fields.meta_description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('cruds.subsubcategory.fields.name'))->searchable(),
                TextColumn::make('subcategory.name')->label(__('cruds.subsubcategory.fields.subcategory'))->searchable(),
                TextColumn::make('subcategory.category.name')->label(__('cruds.subsubcategory.fields.category'))->searchable(),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubSubCategories::route('/'),
            'create' => Pages\CreateSubSubCategory::route('/create'),
            'edit' => Pages\EditSubSubCategory::route('/{record}/edit'),
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
