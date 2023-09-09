<?php

use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admin')->as('admin.')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('login');
    });

    Route::middleware(['auth:api', 'admin'])->group(function () {

        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout')->name('logout');
        });
        Route::controller(UserController::class)->as('user.')->group(function () {
            Route::get('user-listing', 'listing')->name('listing');
            Route::post('create', 'store')->name('store');
            Route::put('user-edit/{user}', 'update')->name('update');
            Route::delete('user-delete/{user}', 'destroy')->name('destroy');
        });
    });
});
