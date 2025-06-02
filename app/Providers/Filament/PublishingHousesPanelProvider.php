<?php

namespace App\Providers\Filament;

use App\Filament\PublishingHouses\Pages\Auth\Register;
use App\Http\Middleware\CheckUserPublishingHouse;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TomatoPHP\FilamentLanguageSwitcher\FilamentLanguageSwitcherPlugin;

class PublishingHousesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('publishing-houses')
            ->path('publisher')
            ->colors([
                'primary' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/PublishingHouses/Resources'), for: 'App\\Filament\\PublishingHouses\\Resources')
            ->discoverPages(in: app_path('Filament/PublishingHouses/Pages'), for: 'App\\Filament\\PublishingHouses\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->login()
            ->registration(Register::class)
            ->passwordReset()
            ->emailVerification()
            ->discoverWidgets(in: app_path('Filament/PublishingHouses/Widgets'), for: 'App\\Filament\\PublishingHouses\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                CheckUserPublishingHouse::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentLanguageSwitcherPlugin::make());
    }
}
