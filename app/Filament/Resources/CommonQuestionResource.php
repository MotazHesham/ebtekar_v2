<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommonQuestionResource\Pages;
use App\Filament\Resources\CommonQuestionResource\RelationManagers;
use App\Models\CommonQuestion;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommonQuestionResource extends Resource
{
    protected static ?string $model = CommonQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function getModelLabel(): string
    {
        return __('cruds.common_question.navigation_label');
    }

    public static function getPluralLabel(): string
    {
        return __('cruds.common_question.navigation_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('cruds.common_question.navigation_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('cruds.common_question.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')
                        ->required()
                        ->label(__('cruds.common_question.fields.question')),
                RichEditor::make('answer')
                        ->required()
                        ->label(__('cruds.common_question.fields.answer'))
                        ->disableToolbarButtons([
                            'attachFiles',
                            'codeBlock',
                        ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->label(__('cruds.common_question.fields.question'))->searchable(),
                TextColumn::make('answer')->label(__('cruds.common_question.fields.answer'))->html(),
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
            'index' => Pages\ListCommonQuestions::route('/'),
            'create' => Pages\CreateCommonQuestion::route('/create'),
            'edit' => Pages\EditCommonQuestion::route('/{record}/edit'),
        ];
    }
}
