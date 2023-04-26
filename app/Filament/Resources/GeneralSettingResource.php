<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralSettingResource\Pages;
use App\Filament\Resources\GeneralSettingResource\RelationManagers;
use App\Models\GeneralSetting;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeneralSettingResource extends Resource
{
    protected static ?string $model = GeneralSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function getModelLabel(): string
    {
        return __('cruds.generalsetting.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.generalsetting.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.generalsetting.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.generalsetting.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo')
                            ->label(__('cruds.generalsetting.fields.logo'))
                            ->directory('uploads/logo')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->image()
                            ->imagePreviewHeight('100'),
                TextInput::make('site_name')
                            ->label(__('cruds.generalsetting.fields.site_name')),
                TextInput::make('address')
                            ->label(__('cruds.generalsetting.fields.address')),
                TextInput::make('description')
                            ->label(__('cruds.generalsetting.fields.description')),
                TextInput::make('phone_number')
                            ->label(__('cruds.generalsetting.fields.phone_number')),
                TextInput::make('email')
                            ->label(__('cruds.generalsetting.fields.email')),
                TextInput::make('facebook')
                            ->label(__('cruds.generalsetting.fields.facebook')),
                TextInput::make('instagram')
                            ->label(__('cruds.generalsetting.fields.instagram')),
                TextInput::make('twitter')
                            ->label(__('cruds.generalsetting.fields.twitter')),
                TextInput::make('telegram')
                            ->label(__('cruds.generalsetting.fields.telegram')),
                TextInput::make('linkedin')
                            ->label(__('cruds.generalsetting.fields.linkedin')),
                TextInput::make('whatsapp')
                            ->label(__('cruds.generalsetting.fields.whatsapp')),
                TextInput::make('youtube')
                            ->label(__('cruds.generalsetting.fields.youtube')),
                TextInput::make('google_plus')
                            ->label(__('cruds.generalsetting.fields.google_plus')),
                Select::make('designer_id')
                    ->label(__('cruds.playlist.design'))
                    ->options(session('playlist_users')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Select::make('preparer_id')
                    ->label(__('cruds.playlist.manufacturing'))
                    ->options(session('playlist_users')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Select::make('manufacturer_id')
                    ->label(__('cruds.playlist.prepare'))
                    ->options(session('playlist_users')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Select::make('send_to_delivery_id')
                    ->label(__('cruds.playlist.send_to_delivery'))
                    ->options(session('playlist_users')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Textarea::make('welcome_message')
                            ->label(__('cruds.generalsetting.fields.welcome_message')),
                FileUpload::make('photos')
                    ->label(__('cruds.generalsetting.fields.photos'))
                    ->directory('uploads/settings/photos')
                    ->multiple()
                    ->enableOpen()
                    ->maxSize(2048)
                    ->maxFiles(5)
                    ->image()
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1920')
                    ->imageResizeTargetHeight('1080')
                    ->imagePreviewHeight('100')
                    ->enableReordering(),
                TextInput::make('video_instructions')
                            ->label(__('cruds.generalsetting.fields.video_instructions')),
                Select::make('delivery_system')
                            ->label(__('cruds.generalsetting.fields.delivery_system'))->options(['wasla' => 'wasla' , 'ebtekar' => 'ebtekar']),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->label(__('cruds.generalsetting.fields.logo')),
                TextColumn::make('site_name')->label(__('cruds.generalsetting.fields.site_name'))
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
            'index' => Pages\ListGeneralSettings::route('/'),
            // 'create' => Pages\CreateGeneralSetting::route('/create'),
            'edit' => Pages\EditGeneralSetting::route('/{record}/edit'),
        ];
    }
}
