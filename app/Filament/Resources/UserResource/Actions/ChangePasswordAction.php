<?php
namespace App\Filament\Resources\UserResource\Actions;

use App\Models\User;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public static function make(): \Filament\Tables\Actions\Action
    {
        return \Filament\Tables\Actions\Action::make('change_password')
            ->label('Password')
            ->iconButton()
            ->icon('heroicon-o-key')
            ->color('primary')
            ->requiresConfirmation()
            ->form(fn ($record) : array => [
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->required()
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($record) {
                            if (! $record || !Hash::check($value, $record->password)) {
                                $fail('The current password is incorrect.');
                            }
                        },
                    ]),

                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->required()
                    ->same('password')
                    ->dehydrated(false),
            ])
            ->action(function (User $record, array $data): void {
                 if (!Hash::check($data['current_password'], $record->password)) {
                    Notification::make()
                        ->title('Current Password Incorrect')
                        ->danger()
                        ->body('The current password is incorrect.')
                        ->send();
                    return;
                }
                $record->password = Hash::make($data['password']);
                $record->save();
                Notification::make()
                    ->success()
                    ->title('Password Changed Successfully')
                    ->body('The password has been changed successfully.')
                    ->send();

            });
    }
}
