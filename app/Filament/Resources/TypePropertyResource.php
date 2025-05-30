<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypePropertyResource\Pages;
use App\Filament\Resources\TypePropertyResource\RelationManagers;
use App\Models\TypeProperty;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class TypePropertyResource extends Resource
{
    protected static ?string $model = TypeProperty::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Property Settings';
    protected static ?int $navigationSort = 1;


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
                    //->onlyMainLocaleRequired() // optional
                    ->requiredLocales(array_keys(config('app.locales'))) // optional
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
            'index' => Pages\ListTypeProperties::route('/'),
        ];
    }
}
