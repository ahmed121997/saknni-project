<?php

namespace App\Filament\Resources\TypeFinishResource\Pages;

use App\Filament\Resources\TypeFinishResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTypeFinish extends ViewRecord
{
    protected static string $resource = TypeFinishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
