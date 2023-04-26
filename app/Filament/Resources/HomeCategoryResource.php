<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeCategoryResource\Pages;
use App\Filament\Resources\HomeCategoryResource\RelationManagers;
use App\Models\HomeCategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeCategoryResource extends Resource
{
    protected static ?string $model = HomeCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getModelLabel(): string
    {
        return __('cruds.homecategory.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.homecategory.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.homecategory.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.homecategory.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                        ->label(__('cruds.homecategory.fields.category'))
                        ->relationship('category','name')
                        ->searchable()
                        ->required()
                        ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                            ->label(__('cruds.homecategory.fields.category')),
                IconColumn::make('published')
                            ->label(__('cruds.homecategory.fields.published'))->boolean()->toggle(),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHomeCategories::route('/'),
            'create' => Pages\CreateHomeCategory::route('/create'),
            'edit' => Pages\EditHomeCategory::route('/{record}/edit'),
        ];
    }
}
