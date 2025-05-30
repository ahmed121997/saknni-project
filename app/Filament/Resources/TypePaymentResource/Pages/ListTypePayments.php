<?php

namespace App\Filament\Resources\TypePaymentResource\Pages;

use App\Filament\Resources\TypePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypePayments extends ListRecords
{
    protected static string $resource = TypePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
