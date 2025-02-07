<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ShoppingListController;
use Illuminate\Support\Facades\Route;


Route::middleware('api')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::middleware([
            'jwt.auth'
        ])
        ->group(function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

            Route::prefix('/shopping-lists')
                ->name('shopping-lists.')
                ->controller(ShoppingListController::Class)
                ->group(function () {
                    Route::get('/index', 'index')->name('index');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/show/{shoppingList}', 'show')->name('show');
                    Route::post('/update/{shoppingList}', 'update')->name('update');
                    Route::post('/destroy', 'destroy')->name('destroy');
                    Route::post('/dashboard', 'dashboard')->name('destroy');
                });
            Route::prefix('/dashboard')
                ->name('dashboard.')
                ->controller(DashboardController::Class)
                ->group(function () {
                    Route::get('/', 'dashboard')->name('dashboard');
                });
        });
    });
