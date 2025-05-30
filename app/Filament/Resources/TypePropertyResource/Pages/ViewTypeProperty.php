<?php

namespace App\Filament\Resources\TypePropertyResource\Pages;

use App\Filament\Resources\TypePropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTypeProperty extends ViewRecord
{
    protected static string $resource = TypePropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
