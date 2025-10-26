<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

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
    Filament::serving(function () {
        Filament::getPanel()
            ->brandLogo(asset('images/mi-logo-dark.png')) // Logo para modo claro
            ->darkModeBrandLogo(asset('images/mi-logo.png')); // Logo para modo oscuro
    });
}
}
