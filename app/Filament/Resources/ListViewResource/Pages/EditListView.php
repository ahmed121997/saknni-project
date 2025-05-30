<?php

namespace App\Filament\Resources\ListViewResource\Pages;

use App\Filament\Resources\ListViewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditListView extends EditRecord
{
    protected static string $resource = ListViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
