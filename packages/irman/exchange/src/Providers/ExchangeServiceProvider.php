<?php

namespace Irman\Exchange\Providers;

use Illuminate\Support\ServiceProvider;

class ExchangeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/exchange.php' => config_path('exchange.php'),
        ], 'exchange-config');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/route.php');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/exchange.php',
            'exchange'
        );
    }
}
