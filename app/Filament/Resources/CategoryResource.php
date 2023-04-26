<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('cruds.category.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.category.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.category.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.category.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->label(__('cruds.category.fields.name'))
                            ->required(),
                FileUpload::make('banner')
                            ->label(__('cruds.category.fields.banner'))
                            ->directory('uploads/brands')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->image()
                            ->imagePreviewHeight('100')
                            ->required(),
                FileUpload::make('icon')
                            ->label(__('cruds.category.fields.icon'))
                            ->directory('uploads/brands')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->image()
                            ->imagePreviewHeight('100')
                            ->required(),
                TextInput::make('meta_title')
                            ->label(__('cruds.category.fields.meta_title')),
                TextInput::make('meta_description')
                            ->label(__('cruds.category.fields.meta_description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                            ->label(__('cruds.category.fields.name'))->searchable(),
                ImageColumn::make('banner')
                            ->label(__('cruds.category.fields.banner')),
                ImageColumn::make('icon')
                            ->label(__('cruds.category.fields.icon')),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
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
