<?php

use App\Http\Controllers\Api\V1\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MainController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AdminController;

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

Route::prefix('admin')->as('admin.')->group(
    function () {
        Route::controller(AdminController::class)->group(function () {
            Route::post('login', 'login')->name('login');
        });

        Route::middleware(['auth:api', 'admin'])->group(function () {

            Route::controller(AdminController::class)->group(function () {
                Route::get('logout', 'logout')->name('logout');
            });
            Route::controller(AdminController::class)->as('user.')->group(function () {
                Route::get('user-listing', 'listing')->name('listing');
                Route::post('create', 'store')->name('store');
                Route::put('user-edit/{user}', 'update')->name('update');
                Route::delete('user-delete/{user}', 'destroy')->name('destroy');
            });
        });

    }
);

Route::prefix('user')->as('user.')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('create', 'store')->name('store');
        Route::post('forgot-password', 'forgotPassword')->name('forgot-password');
        Route::post('reset-password-token', 'resetPassword')->name('reset-password');
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('logout', 'logout')->name('logout');
            Route::get('', 'index')->name('index');
            Route::put('edit', 'update')->name('update');
            Route::delete('', 'destroy')->name('destroy');
            Route::get('orders', 'orders')->name('orders');
        });
    });
});

Route::prefix('main')->as('main.')->controller(MainController::class)->group(function() {
    Route::get('promotions', 'promotions')->name('promotions');
    Route::get('blog', 'posts')->name('posts');
    Route::get('blog/{post}', 'postIndex')->name('post.index');
});

Route::prefix('order')->as('order.')->controller(OrderController::class)->group(function() {
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::put('{order}', 'update')->name('update');
    });
});
