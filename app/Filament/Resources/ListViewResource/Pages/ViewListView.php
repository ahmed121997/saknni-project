<?php

namespace App\Filament\Resources\ListViewResource\Pages;

use App\Filament\Resources\ListViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewListView extends ViewRecord
{
    protected static string $resource = ListViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
