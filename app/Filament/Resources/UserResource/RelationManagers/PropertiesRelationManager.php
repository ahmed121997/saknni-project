<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\City;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                  Section::make('Property Details')
                    ->columns(2)
                    ->schema([
                        Select::make('type_property_id')
                            ->label('Type of Property')
                            ->relationship('typeProperty', 'name')
                            ->required()
                            ->native(false),
                        Select::make('list_view_id')
                            ->label('List View')
                            ->relationship('view', 'name')
                            ->required()
                            ->native(false),
                        Select::make('type_finish_id')
                            ->label('Type of Finish')
                            ->relationship('finish', 'name')
                            ->required()
                            ->native(false),
                        Select::make('list_section')
                                ->label('List Section')
                                ->native(false)
                                ->options([
                                    'sell' => 'For Sale',
                                    'rent' => 'For Rent',
                                ])->required(),
                    ]),
                Section::make('Property Location')
                    ->columns(2)
                    ->schema([
                        Select::make('governorate_id')
                            ->label('Governorate')
                            ->relationship('governorate', 'name')
                            ->live()
                            ->required()
                            ->afterStateUpdated(function(Set $set) : void {
                                $set('city_id', null);
                            })
                            ->preload()
                            ->searchable()
                            ->native(false),
                        Select::make('city_id')
                            ->label('City')
                            ->options(fn (Get $get) : Collection => City::query()->where('governorate_id', $get('governorate_id'))->pluck('name', 'id'))
                            ->native(false)
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),
                        Forms\Components\Textarea::make('location')
                            ->label('Location')
                            ->columnSpanFull(),
                    ]),
                Section::make('Payment Details')
                    ->columns(3)
                    ->schema([
                        Select::make('type_payment_id')
                            ->label('Type of Payment')
                            ->relationship('payment', 'name')
                            ->required()
                            ->native(false),
                        Select::make('type_rent')
                            ->label('Type of Rent')
                            ->native(false)
                            ->required()
                            ->options([
                                'daily' => 'Daily',
                                'monthly' => 'Monthly',
                            ]),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('$'),
                    ]),
                Section::make('Property Specifications')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('area')
                            ->label('Area (m²)')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('num_floor')
                            ->label('Number of Floors')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('num_rooms')
                            ->label('Number of Rooms')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('num_bathroom')
                            ->label('Number of Bathrooms')
                            ->required()
                            ->numeric(),
                    ]),
                Section::make('Additional Information')
                    ->columns(columns: 2)
                    ->schema([
                       Forms\Components\Toggle::make('is_special')
                            ->label('Is Special')
                            ->required(),
                        Forms\Components\Toggle::make('status')
                            ->label('Status')
                            ->required(),
                        Forms\Components\TextInput::make('link_youtube')
                            ->label('YouTube Link')
                            ->url()
                            ->columnSpanFull()
                            ->nullable()
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type_property_id')
            ->columns([
                Tables\Columns\TextColumn::make('typeProperty.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('governorate.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('list_view.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type_finish.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type_payment.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type_rent'),
                Tables\Columns\TextColumn::make('list_section'),
                Tables\Columns\TextColumn::make('area')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
