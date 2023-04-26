<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe';

    public static function getModelLabel(): string
    {
        return __('cruds.country.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.country.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.country.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.country.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->label(__('cruds.country.fields.name'))
                            ->required(),
                TextInput::make('cost')
                            ->label(__('cruds.country.fields.cost'))
                            ->numeric()
                            ->required(),
                TextInput::make('code')
                            ->label(__('cruds.country.fields.code'))
                            ->required(),
                TextInput::make('code_cost')
                            ->label(__('cruds.country.fields.code_cost'))
                            ->numeric()
                            ->required(),
                Select::make('type')
                            ->required()
                            ->label(__('cruds.country.fields.type'))
                            ->options(__('global.countries_type')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                            ->label(__('cruds.country.fields.name'))
                            ->searchable(),
                TextColumn::make('cost')
                            ->label(__('cruds.country.fields.cost')),
                TextColumn::make('code')
                            ->label(__('cruds.country.fields.code'))
                            ->searchable(),
                TextColumn::make('code_cost')
                            ->label(__('cruds.country.fields.code_cost')),
                TextColumn::make('type')
                            ->label(__('cruds.country.fields.type')),
                IconColumn::make('website')
                            ->label(__('cruds.country.fields.website'))
                            ->boolean()->toggle(),
                IconColumn::make('status')
                            ->label(__('cruds.country.fields.status'))
                            ->boolean()->toggle(),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('type')->label(__('cruds.country.fields.type'))
                    ->options(__('global.countries_type')),
                TernaryFilter::make('website')->label(__('cruds.country.fields.website')),
                TernaryFilter::make('status')->label(__('cruds.country.fields.status')),
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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
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
