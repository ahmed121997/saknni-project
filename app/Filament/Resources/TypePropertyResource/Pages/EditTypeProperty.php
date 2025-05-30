<?php

namespace App\Filament\Resources\TypePropertyResource\Pages;

use App\Filament\Resources\TypePropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeProperty extends EditRecord
{
    protected static string $resource = TypePropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
