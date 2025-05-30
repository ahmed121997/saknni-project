<?php

namespace App\Filament\Resources\ListViewResource\Pages;

use App\Filament\Resources\ListViewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateListView extends CreateRecord
{
    protected static string $resource = ListViewResource::class;
}
