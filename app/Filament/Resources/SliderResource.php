<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    public static function getModelLabel(): string
    {
        return __('cruds.slider.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.slider.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.slider.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.slider.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')
                            ->label(__('cruds.slider.fields.photo'))
                            ->directory('uploads/sliders')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(5)
                            ->image()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imagePreviewHeight('100')
                            ->enableReordering()
                            ->required(),
                TextInput::make('url')
                            ->label(__('cruds.slider.fields.url')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                            ->label(__('cruds.slider.fields.photo')),
                TextColumn::make('url')
                            ->label(__('cruds.slider.fields.url')),
                IconColumn::make('published')
                            ->label(__('cruds.slider.fields.published'))->boolean()->toggle()
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
