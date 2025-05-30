<?php

namespace App\Filament\Settings\Forms;

use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class Custom
{
    /**
     * @return Tab
     */
    public static function getTab(): Tab
    {
        return Tab::make('custom')
                    ->label(__('Custom'))
                    ->icon('heroicon-o-computer-desktop')
                    ->schema(self::getFields())
                    ->columns()
                    ->statePath('custom')
                    ->visible(true);
    }

    public static function getFields(): array
    {
        return [
            TextInput::make('custom_field_1')
                ->label(__('Custom Field 1'))
                ->maxLength(255)
                ->required()
                ->columnSpanFull(),
        ];
    }

    public static function getSortOrder(): int
    {
       return 1;
    }
}
