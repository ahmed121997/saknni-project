<?php
namespace App\Filament\Resources\UserResource\Actions;

use Filament\Tables\Actions\Action;
use App\Models\User;
use Filament\Notifications\Notification;

class VerifyUserAction
{
    public static function make(): Action
    {
        return Action::make('verify_user')
            ->label('Verify')
            ->icon('heroicon-m-check-badge')
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (User $record): bool => !$record->hasVerifiedEmail())
            ->action(function (User $record): void {
                $record->markEmailAsVerified();
                Notification::make()
                ->success()
                ->title('User verified successfully')
                ->body('The user has been marked as verified.')
                ->send();
            });

    }
}
