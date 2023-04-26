<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('cruds.review.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.review.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.review.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.review.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                            ->label(__('cruds.review.fields.product'))->searchable(),
                TextColumn::make('user.name')
                            ->label(__('cruds.review.fields.user'))->searchable(),
                TextColumn::make('rating')
                            ->label(__('cruds.review.fields.rating'))->sortable(),
                TextColumn::make('comment')
                            ->label(__('cruds.review.fields.comment'))->searchable(),
                ToggleColumn::make('status')
                            ->label(__('cruds.review.fields.status')),
            ])
            ->defaultSort('created_at','desc')
            ->filters([
                TernaryFilter::make('status'),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListReviews::route('/'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    protected static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
