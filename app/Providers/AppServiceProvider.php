<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        # Ignore sanctum migrations. Since we're implementing our own authentications.
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     * @throws Exception
     */
    public function boot(): void
    {
        # Get JWT content from the paths and set it in the config.
        $items = [
            'jwk',
            'private_key',
            'public_key',
        ];
        $invalid = false;
        foreach ($items as $item) {
            if ($path = config('auth.jwt.' . $item . '_path')) {
                $content = File::get($path);
                if ($item === 'jwk') {
                    $content = json_decode($content, true);
                }

                if ($content) {
                    config(['auth.jwt.' . $item => $content]);
                } else {
                    $invalid = true;
                }
            } else {
                $invalid = true;
            }
        }
        if ($invalid) {
            throw new Exception('Invalid jwt configuration. See config/auth.php');
        }
    }
}
