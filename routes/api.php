<?php

use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAPI;

/** User Before Login */
Route::controller(AuthAPI::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    /** User After Login */
    Route::controller(AuthAPI::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });

    Route::controller(BlogController::class)->group(function () {
        Route::prefix('blogs')->group(function () {
            Route::put('active', 'active');
            Route::put('inactive', 'inactive');
            Route::get('', 'index');
            Route::get('{id}', 'show');
            Route::post('', 'create');
            Route::put('{id}', 'update');
            Route::delete('', 'delete');
        });
    });
});


