<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getModelLabel(): string
    {
        return __('cruds.customer.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.customer.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.customer.navigation_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label(__('cruds.user.fields.name')),
                TextInput::make('email')
                            ->unique(User::class)
                            ->required()
                            ->email()
                            ->label(__('cruds.user.fields.email')),
                TextInput::make('phone_number')->label(__('cruds.user.fields.phone_number'))
                            ->required()
                            ->regex('/(01)[0-9]{9}/'),
                TextInput::make('address')->required()->label(__('cruds.user.fields.address')),
                TextInput::make('password')->required()->label(__('cruds.user.fields.password'))->password()->confirmed(),
                TextInput::make('password_confirmation')->required()->label(__('cruds.user.fields.password_confirmation'))->password(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('cruds.customer.fields.name'))->searchable(),
                TextColumn::make('user.email')->label(__('cruds.customer.fields.email'))->searchable(),
                TextColumn::make('user.phone_number')->label(__('cruds.customer.fields.phone_number'))->searchable(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
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
