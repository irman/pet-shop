<?php

namespace Irman\Notify\Providers;

use Illuminate\Support\ServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/notify.php' => config_path('notify.php'),
        ], 'notify-config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/notify.php',
            'notify'
        );
    }
}
