<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QualityResponsibleResource\Pages;
use App\Filament\Resources\QualityResponsibleResource\RelationManagers;
use App\Models\QualityResponsible;
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

class QualityResponsibleResource extends Resource
{
    protected static ?string $model = QualityResponsible::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function getModelLabel(): string
    {
        return __('cruds.quality_responsible.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.quality_responsible.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.quality_responsible.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.quality_responsible.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')
                            ->label(__('cruds.quality_responsible.fields.photo'))
                            ->directory('uploads/quality_responsible')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(5)
                            ->image()
                            ->imagePreviewHeight('100')
                            ->enableReordering()
                            ->required(),
                TextInput::make('name')
                            ->label(__('cruds.quality_responsible.fields.name'))
                            ->required(),
                TextInput::make('phone_number')
                            ->label(__('cruds.quality_responsible.fields.phone_number'))
                            ->required()
                            ->regex('/(01)[0-9]{9}/'),
                TextInput::make('country_code')
                            ->label(__('cruds.quality_responsible.fields.country_code'))
                            ->required(),
                TextInput::make('wts_phone')
                            ->label(__('cruds.quality_responsible.fields.wts_phone'))
                            ->required()
                            ->regex('/(01)[0-9]{9}/'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                            ->label(__('cruds.quality_responsible.fields.photo'))->circular(),
                TextColumn::make('name')
                            ->label(__('cruds.quality_responsible.fields.name')),
                TextColumn::make('phone_number')
                            ->label(__('cruds.quality_responsible.fields.phone_number')),
                TextColumn::make('country_code')
                            ->label(__('cruds.quality_responsible.fields.country_code')),
                TextColumn::make('wts_phone')
                            ->label(__('cruds.quality_responsible.fields.wts_phone')),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListQualityResponsibles::route('/'),
            'create' => Pages\CreateQualityResponsible::route('/create'),
            'edit' => Pages\EditQualityResponsible::route('/{record}/edit'),
        ];
    }
}
