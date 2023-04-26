<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellerResource\Pages;
use App\Filament\Resources\SellerResource\RelationManagers;
use App\Models\Seller;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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


class SellerResource extends Resource
{

    protected static ?string $model = Seller::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    public static function getModelLabel(): string
    {
        return __('cruds.seller.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.seller.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.seller.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.seller.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                            ->label(__('cruds.seller.fields.name'))
                            ->required(),
                TextInput::make('email')
                            ->label(__('cruds.seller.fields.email'))
                            ->required()
                            ->unique(User::class)
                            ->email(),
                TextInput::make('phone_number')
                            ->label(__('cruds.seller.fields.phone_number'))
                            ->required()
                            ->regex('/(01)[0-9]{9}/'),
                TextInput::make('address')
                            ->label(__('cruds.seller.fields.address'))
                            ->required(),
                TextInput::make('password')
                            ->label(__('cruds.seller.fields.password'))
                            ->confirmed()
                            ->required()
                            ->password(),
                TextInput::make('password_confirmation')
                            ->label(__('cruds.seller.fields.password_confirmation'))
                            ->password()
                            ->required(),
                Select::make('type')
                            ->required()
                            ->label(__('cruds.seller.fields.type'))
                            ->options(['seller' => 'Seller' , 'social' => 'Social']),
                TextInput::make('social_name')
                            ->label(__('cruds.seller.fields.social_name'))
                            ->required(),
                TextInput::make('social_link')
                            ->label(__('cruds.seller.fields.social_link'))
                            ->required(),
                TextInput::make('qualification')
                            ->label(__('cruds.seller.fields.qualification')),
                TextInput::make('order_out_website')
                            ->label(__('cruds.seller.fields.order_out_website'))->numeric(),
                FileUpload::make('identity_front')
                            ->label(__('cruds.seller.fields.identity_front'))
                            ->directory('uploads/sellers/identity')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(5)
                            ->image()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imagePreviewHeight('100')
                            ->enableReordering(),
                FileUpload::make('identity_back')
                            ->label(__('cruds.seller.fields.identity_back'))
                            ->directory('uploads/sellers/identity')
                            ->enableOpen()
                            ->maxSize(2048)
                            ->maxFiles(5)
                            ->image()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->imagePreviewHeight('100')
                            ->enableReordering(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('cruds.seller.fields.name'))->searchable(),
                TextColumn::make('user.email')->label(__('cruds.seller.fields.email'))->searchable(),
                TextColumn::make('user.phone_number')->label(__('cruds.seller.fields.phone_number'))->searchable(),
                TextColumn::make('seller_code')->label(__('cruds.seller.fields.seller_code'))->searchable(),
                IconColumn::make('verification_status')->label(__('cruds.seller.fields.verification_status'))->boolean()->toggle()
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
            'index' => Pages\ListSellers::route('/'),
            'create' => Pages\CreateSeller::route('/create'),
            'edit' => Pages\EditSeller::route('/{record}/edit'),
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
