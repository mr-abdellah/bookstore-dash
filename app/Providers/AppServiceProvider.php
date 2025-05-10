<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en', 'fr'])
                ->displayLocale('en') // Show locale names in English (optional)
                ->labels([
                    'en' => 'English',
                    'fr' => 'Français',
                    'ar' => 'العربية',
                ])
                ->flags([
                    'ar' => asset('flags/ar.png'),
                    'fr' => asset('flags/fr.png'),
                    'en' => asset('flags/en.png'),
                ])
                ->visible(
                    insidePanels: true,
                    outsidePanels: false // You don’t need this unless you have frontend pages
                )
                ->renderHook('panels::global-search.after'); // Position in Filament header
        });
        Schema::defaultStringLength(191);
    }
}
