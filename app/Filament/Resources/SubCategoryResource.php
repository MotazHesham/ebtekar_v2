<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCategoryResource\Pages;
use App\Filament\Resources\SubCategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-duplicate';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('cruds.subcategory.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.subcategory.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.subcategory.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.subcategory.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->label(__('cruds.subcategory.fields.name'))
                            ->required(),
                Select::make('category_id')
                            ->label(__('cruds.subcategory.fields.category'))
                            ->options(Category::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                TextInput::make('meta_title')
                            ->label(__('cruds.subcategory.fields.meta_title')),
                TextArea::make('meta_description')
                            ->label(__('cruds.subcategory.fields.meta_description'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label(__('cruds.subcategory.fields.name'))->searchable(),
                TextColumn::make('category.name')
                ->label(__('cruds.subcategory.fields.category'))->searchable(),
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
            'index' => Pages\ListSubCategories::route('/'),
            'create' => Pages\CreateSubCategory::route('/create'),
            'edit' => Pages\EditSubCategory::route('/{record}/edit'),
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
