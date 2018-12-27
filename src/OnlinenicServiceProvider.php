<?php

namespace Pezhvak\OnlinenicApi;

use Illuminate\Support\ServiceProvider;

class OnlinenicServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/onlinenic.php' => config_path('onlinenic.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/onlinenic.php', 'onlinenic'
        );

        $this->app->bind('Pezhvak\OnlinenicApi\Onlinenic', function () {
            return new Onlinenic(config('onlinenic.account'), config('onlinenic.password'), config('onlinenic.api_key'), config('onlinenic.sandbox_mode'));
        });
    }
}