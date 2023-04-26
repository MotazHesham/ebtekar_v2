<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannedPhoneResource\Pages;
use App\Filament\Resources\BannedPhoneResource\RelationManagers;
use App\Models\BannedPhone;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannedPhoneResource extends Resource
{
    protected static ?string $model = BannedPhone::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-missed-call';

    public static function getModelLabel(): string
    {
        return __('cruds.banned_phone.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.banned_phone.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.banned_phone.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.banned_phone.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone_number')
                        ->label(__('cruds.banned_phone.fields.phone_number'))
                        ->required()
                        ->regex('/(01)[0-9]{9}/'),
                TextInput::make('reason')
                        ->label(__('cruds.banned_phone.fields.reason')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone_number')
                            ->label(__('cruds.banned_phone.fields.phone_number'))->searchable(),
                TextColumn::make('reason')
                            ->label(__('cruds.banned_phone.fields.reason')),
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
            'index' => Pages\ListBannedPhones::route('/'),
            'create' => Pages\CreateBannedPhone::route('/create'),
            'edit' => Pages\EditBannedPhone::route('/{record}/edit'),
        ];
    }
}
