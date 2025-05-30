<?php

namespace App\Filament\Resources\GovernorateResource\Pages;

use App\Filament\Resources\GovernorateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGovernorate extends ViewRecord
{
    protected static string $resource = GovernorateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
