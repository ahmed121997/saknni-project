<?php

namespace App\Providers\Filament;

use CWSPS154\AppSettings\AppSettingsPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\UserMenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('dashboard')
            ->authGuard('admin')
            ->profile()
            ->userMenuItems([
                MenuItem::make()
                    ->label('Website')
                    ->icon('heroicon-o-globe-alt')
                    ->url('/')
                    ->openUrlInNewTab(),
            ])
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(fn () : string => asset('logo.jpg'))
            ->brandLogoHeight('3rem')
            ->favicon(fn () : string => asset('logo.jpg'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->navigationGroups([
                'Location Settings',
                'Property Settings',
                'Translations'
            ])
            ->plugins([AppSettingsPlugin::make()->canAccess(function () {
                    return true;
                })
                ->canAccessAppSectionTab(function () {
                    return true;
                })
                ->appAdditionalField([])]
            )
            ->plugin(\TomatoPHP\FilamentLanguageSwitcher\FilamentLanguageSwitcherPlugin::make())
            ->plugin(SpatieLaravelTranslatablePlugin::make()->defaultLocales(array_keys(config('app.locales'))))
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
