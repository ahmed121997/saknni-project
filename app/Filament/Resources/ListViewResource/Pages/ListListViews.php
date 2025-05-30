<?php

namespace App\Filament\Resources\ListViewResource\Pages;

use App\Filament\Resources\ListViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListViews extends ListRecords
{
    protected static string $resource = ListViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
