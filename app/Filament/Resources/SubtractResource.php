<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubtractResource\Pages;
use App\Filament\Resources\SubtractResource\RelationManagers;
use App\Models\Subtract;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubtractResource extends Resource
{
    protected static ?string $model = Subtract::class;

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    public static function getModelLabel(): string
    {
        return __('cruds.subtract.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.subtract.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.subtract.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.subtract.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('subtract_user_id')
                        ->label(__('cruds.subtract.fields.subtract_user_id'))
                        ->relationship('subtract_user','name')
                        ->preload()
                        ->searchable()
                        ->required(),
                TextInput::make('amount')
                        ->label(__('cruds.subtract.fields.amount'))
                        ->numeric()
                        ->required(),
                TextInput::make('reason')
                        ->label(__('cruds.subtract.fields.reason')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subtract_user.name')
                            ->label(__('cruds.subtract.fields.subtract_user_id'))->searchable(),
                TextColumn::make('reason')
                            ->label(__('cruds.subtract.fields.reason')),
                TextColumn::make('amount')
                            ->label(__('cruds.subtract.fields.amount')),
                TextColumn::make('created_at')
                            ->label(__('cruds.subtract.fields.created_at')),
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
            'index' => Pages\ListSubtracts::route('/'),
            'create' => Pages\CreateSubtract::route('/create'),
            'edit' => Pages\EditSubtract::route('/{record}/edit'),
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
