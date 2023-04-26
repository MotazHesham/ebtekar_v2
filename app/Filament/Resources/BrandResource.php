<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
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

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('cruds.brand.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.brand.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.brand.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.brand.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->required()
                            ->label(__('cruds.brand.fields.name')),
                FileUpload::make('logo')
                            ->label(__('cruds.brand.fields.logo'))
                            ->directory('uploads/brands')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->image()
                            ->imagePreviewHeight('100'),
                TextInput::make('meta_title')
                            ->label(__('cruds.brand.fields.meta_title')),
                TextInput::make('meta_description')
                            ->label(__('cruds.brand.fields.meta_description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                            ->label(__('cruds.brand.fields.name'))->searchable(),
                ImageColumn::make('logo')
                            ->label(__('cruds.brand.fields.logo'))
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
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
