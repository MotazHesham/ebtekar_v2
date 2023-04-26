<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowUserResource\Pages;
use App\Filament\Resources\BorrowUserResource\RelationManagers;
use App\Models\BorrowUser;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowUserResource extends Resource
{
    protected static ?string $model = BorrowUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('cruds.borrow_user.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.borrow_user.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.borrow_user.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.borrow_user.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->label(__('cruds.borrow_user.fields.name'))
                            ->required(),
                TextInput::make('email')
                            ->label(__('cruds.borrow_user.fields.email'))
                            ->required()
                            ->unique()
                            ->email(),
                TextInput::make('phone_number')
                            ->label(__('cruds.borrow_user.fields.phone_number'))
                            ->regex('/(01)[0-9]{9}/')
                            ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('cruds.borrow_user.fields.name'))->searchable(),
                TextColumn::make('email')->label(__('cruds.borrow_user.fields.email'))->searchable(),
                TextColumn::make('phone_number')->label(__('cruds.borrow_user.fields.phone_number'))->searchable(),
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
            'index' => Pages\ListBorrowUsers::route('/'),
            'create' => Pages\CreateBorrowUser::route('/create'),
            'edit' => Pages\EditBorrowUser::route('/{record}/edit'),
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
