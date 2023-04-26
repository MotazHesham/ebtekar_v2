<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getModelLabel(): string
    {
        return __('cruds.user.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.user.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.user.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.user.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->required()
                            ->label(__('cruds.user.fields.name')),
                TextInput::make('email')
                            ->label(__('cruds.user.fields.email'))
                            ->email()
                            ->required()
                            ->unique(ignorable: fn ($record) => $record),
                TextInput::make('phone_number')
                            ->label(__('cruds.user.fields.phone_number'))
                            ->required()
                            ->regex('/(01)[0-9]{9}/'),
                TextInput::make('address')
                            ->required()
                            ->label(__('cruds.user.fields.address')),
                TextInput::make('password')
                            ->required()
                            ->label(__('cruds.user.fields.password'))
                            ->confirmed()
                            ->password(),
                TextInput::make('password_confirmation')
                            ->label(__('cruds.user.fields.password_confirmation'))
                            ->required()
                            ->password(),
                Select::make('roles')
                        ->label(__('cruds.user.fields.roles'))
                        ->required()
                        ->multiple()
                        ->options(Role::get()->pluck('name','id'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('cruds.user.fields.name'))->searchable(),
                TextColumn::make('email')->label(__('cruds.user.fields.email'))->searchable(),
                TextColumn::make('phone_number')->label(__('cruds.user.fields.phone_number'))->searchable(),
                ViewColumn::make('roles')->label(__('cruds.user.fields.roles'))->view('filament.tables.columns.roles')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_type','staff')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
