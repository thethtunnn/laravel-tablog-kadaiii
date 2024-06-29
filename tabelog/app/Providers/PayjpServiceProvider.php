<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Payjp\Payjp;

class PayjpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Payjp::class, function ($app) {
            return new Payjp(config('services.payjp.secret'));
        });
    }

    public function boot()
    {
        //
    }
}
