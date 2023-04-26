<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-s-photograph';

    public static function getModelLabel(): string
    {
        return __('cruds.banner.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.banner.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.banner.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.banner.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')->label(__('cruds.banner.fields.photo'))
                            ->directory('uploads/banners')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(5)
                            ->image()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imagePreviewHeight('100')
                            ->enableReordering(),
                TextInput::make('url')->label(__('cruds.banner.fields.url')),
                Select::make('position')->label(__('cruds.banner.fields.position'))->options(['1' => '1' , '2' => '2']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                            ->label(__('cruds.banner.fields.photo')),
                TextColumn::make('url')
                            ->label(__('cruds.banner.fields.url')),
                TextColumn::make('position')
                            ->label(__('cruds.banner.fields.position')),
                IconColumn::make('published')
                            ->label(__('cruds.banner.fields.published'))->boolean()->toggle()
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
