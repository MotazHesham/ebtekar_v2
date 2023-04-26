<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoSettingResource\Pages;
use App\Filament\Resources\SeoSettingResource\RelationManagers;
use App\Models\SeoSetting;
use Filament\Forms;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeoSettingResource extends Resource
{
    protected static ?string $model = SeoSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';

    public static function getModelLabel(): string
    {
        return __('cruds.seosetting.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.seosetting.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.seosetting.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.seosetting.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TagsInput::make('keyword')
                            ->label(__('cruds.seosetting.fields.keyword'))->columnSpan('full'),
                TextInput::make('author')
                            ->label(__('cruds.seosetting.fields.author')),
                TextInput::make('revisit')
                            ->label(__('cruds.seosetting.fields.revisit')),
                TextInput::make('sitemap_link')
                            ->label(__('cruds.seosetting.fields.sitemap_link')),
                Textarea::make('description')
                            ->label(__('cruds.seosetting.fields.description')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author')->label(__('cruds.seosetting.fields.author')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSeoSettings::route('/'),
            'edit' => Pages\EditSeoSetting::route('/{record}/edit'),
        ];
    }
}
