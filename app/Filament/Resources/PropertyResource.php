<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Infolists\Components\YouTubeEmbedEntry;
use App\Models\City;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('Client'))
                    ->relationship('user', 'name')
                    ->required()
                    ->disabled(true)
                    ->columnSpanFull()
                    ->native(false),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('num_floor')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('num_rooms')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('num_bathroom')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_special')
                    ->afterStateUpdated(function ($record, $state) {
                        Notification::make()
                            ->title($state ? 'Property marked as special' : 'Property unmarked as special')
                            ->success()
                            ->send();
                    }),
                Tables\Columns\ToggleColumn::make('status')
                    ->afterStateUpdated(function ($record, $state) {
                        Notification::make()
                            ->title($state ? 'Property is active' : 'Property is inactive')
                            ->success()
                            ->send();
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
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
            RelationManagers\ImagesRelationManager::class,
            RelationManagers\CommentsRelationManager::class,
        ];
    }

   public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
               TextEntry::make('user.name')
                    ->label(__('admin.Client')),
                \Filament\Infolists\Components\Section::make('Property Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('typeProperty.name')
                            ->label('Type of Property'),
                        TextEntry::make('list_view.name')
                            ->label('List View'),
                        TextEntry::make('type_finish.name')
                            ->label('Type of Finish'),
                        TextEntry::make('list_section')
                            ->label('List Section'),
                    ]),
                \Filament\Infolists\Components\Section::make('Property Location')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('governorate.name')
                            ->label('Governorate'),
                        TextEntry::make('city.name')
                            ->label('City'),
                        TextEntry::make('location')
                            ->label('Location'),
                    ]),
                \Filament\Infolists\Components\Section::make('Payment Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('payment.name')
                            ->label('Type of Payment'),
                        TextEntry::make('type_rent')
                            ->label('Type of Rent'),
                        TextEntry::make('price')
                            ->label('Price')
                            ->money(),
                    ]),
                \Filament\Infolists\Components\Section::make('Property Specifications')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('area')
                            ->badge(true)
                            ->label('Area (m²)'),
                        TextEntry::make('num_floor')
                            ->label('Number of Floors')->badge(true),
                        TextEntry::make('num_rooms')
                            ->label('Number of Rooms')->badge(true),
                        TextEntry::make('num_bathroom')
                            ->label('Number of Bathrooms')->badge(true),
                    ]),
                \Filament\Infolists\Components\Section::make('Additional Information')
                    ->columns(2)
                    ->schema([
                        IconEntry::make('is_special')
                            ->boolean(),
                        IconEntry::make('status')
                            ->label('Status')
                            ->boolean(),
                    ]),
                 \Filament\Infolists\Components\Section::make('Media')
                    ->columns(1)
                    ->schema([
                        ImageEntry::make('images_sources')
                            ->extraImgAttributes([
                                'class' => 'object-cover rounded-lg me-3', // margin around each image
                                'loading' => 'lazy',
                            ])
                            ->width('10rem')
                            ->height('10rem')
                            ->square()
                            ->label('Property Media'),
                        YouTubeEmbedEntry::make('link_youtube')
                            ->columnSpanFull()
                            ->label('YouTube Link'),
                    ]),
                \Filament\Infolists\Components\Section::make('Timestamps')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            //'create' => Pages\CreateProperty::route('/create'),
            'view' => Pages\ViewProperty::route('/{record}'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }


    // disable create page
    public static function canCreate(): bool
    {
        return false;
    }
}
