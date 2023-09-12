<?php

use Illuminate\Support\Facades\Route;
use Irman\Exchange\Http\Controllers\ExchangeController;

Route::group(config('exchange.route.group'), function (): void {
    Route::get('convert', [ExchangeController::class, 'convert'])
        ->name(config('exchange.route.name'));
});
