<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialResource\Pages;
use App\Filament\Resources\SocialResource\RelationManagers;
use App\Models\Social;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialResource extends Resource
{
    protected static ?string $model = Social::class;

    protected static ?string $navigationIcon = 'heroicon-s-status-online';

    public static function getModelLabel(): string
    {
        return __('cruds.social.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.social.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.social.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.social.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->required()
                            ->label(__('cruds.social.fields.name')),
                FileUpload::make('photo')
                    ->required()
                    ->label(__('cruds.social.fields.photo'))
                    ->directory('uploads/socials')
                    ->enableOpen()
                    ->maxSize(2048)
                    ->maxFiles(5)
                    ->image()
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->imagePreviewHeight('100')
                    ->enableReordering(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label(__('cruds.social.fields.name'))->searchable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSocials::route('/'),
        ];
    }
}
