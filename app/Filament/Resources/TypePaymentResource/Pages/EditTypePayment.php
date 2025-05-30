<?php

namespace App\Filament\Resources\TypePaymentResource\Pages;

use App\Filament\Resources\TypePaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypePayment extends EditRecord
{
    protected static string $resource = TypePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
