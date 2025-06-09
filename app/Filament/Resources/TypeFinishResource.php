<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeFinishResource\Pages;
use App\Filament\Resources\TypeFinishResource\RelationManagers;
use App\Models\TypeFinish;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class TypeFinishResource extends Resource
{
    protected static ?string $model = TypeFinish::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-minus';

    protected static ?int $navigationSort = 3;
    public static function getNavigationGroup(): string
    {
        return __('Property Settings');
    }
    public static function getPluralLabel(): string
    {
        return __('admin.type finishes');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TranslatableContainer::make(
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->required()
                            ->columnSpanFull()
                            ->hint('translatable')
                            ->hintIcon('heroicon-o-language')
                    )
                    ->columnSpanFull()
                    ->requiredLocales(array_keys(config('app.locales')))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->iconButton(),
            ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTypeFinishes::route('/'),
            // 'create' => Pages\CreateTypeFinish::route('/create'),
            // 'view' => Pages\ViewTypeFinish::route('/{record}'),
            // 'edit' => Pages\EditTypeFinish::route('/{record}/edit'),
        ];
    }
}
