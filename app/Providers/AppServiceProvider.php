<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn(): string => <<<'HTML'
            <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
            <style>
                html {
                    font-family: 'Inter', sans-serif !important;
                }
                html[dir="rtl"] {
                    font-family: 'Cairo', sans-serif !important;
                }
            </style>
            HTML
        );
        Schema::defaultStringLength(191);
    }
}
