<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

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

        if (App::environment(['production'])) {
            URL::forceScheme('https');
        }
        // FilamentView::registerRenderHook(
        //     'panels::auth.login.form.after',
        //     fn (): View => view('filament.login_extra')
        // );
    }
}
