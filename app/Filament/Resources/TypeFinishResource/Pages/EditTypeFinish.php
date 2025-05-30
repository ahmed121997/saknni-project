<?php

namespace App\Filament\Resources\TypeFinishResource\Pages;

use App\Filament\Resources\TypeFinishResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeFinish extends EditRecord
{
    protected static string $resource = TypeFinishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
