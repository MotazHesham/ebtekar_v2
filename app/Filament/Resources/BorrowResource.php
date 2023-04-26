<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BorrowResource\Pages;
use App\Filament\Resources\BorrowResource\RelationManagers;
use App\Models\Borrow;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowResource extends Resource
{
    protected static ?string $model = Borrow::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-yen';

    public static function getModelLabel(): string
    {
        return __('cruds.borrow.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.borrow.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.borrow.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.borrow.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('borrow_user_id')
                        ->label(__('cruds.borrow.fields.borrow_user_id'))
                        ->relationship('borrow_user','name')
                        ->searchable()
                        ->preload()
                        ->required(),
                TextInput::make('amount')
                        ->required()
                        ->numeric()
                        ->label(__('cruds.borrow.fields.amount'))->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('borrow_user.name')->label(__('cruds.borrow.fields.borrow_user_id'))->searchable(),
                TextColumn::make('amount')->label(__('cruds.borrow.fields.amount')),
                IconColumn::make('status')->label(__('cruds.borrow.fields.status'))->boolean()->toggle(),
                TextColumn::make('created_at')->label(__('cruds.borrow.fields.created_at')),
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
            'index' => Pages\ListBorrows::route('/'),
            'create' => Pages\CreateBorrow::route('/create'),
            'edit' => Pages\EditBorrow::route('/{record}/edit'),
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
