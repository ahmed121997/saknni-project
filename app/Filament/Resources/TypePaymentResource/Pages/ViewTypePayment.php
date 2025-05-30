<?php

namespace App\Filament\Resources\TypePaymentResource\Pages;

use App\Filament\Resources\TypePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTypePayment extends ViewRecord
{
    protected static string $resource = TypePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
