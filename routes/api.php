<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
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
});


Route::controller(CategoryController::class)->group(function () {
    Route::prefix('categories')->group(function () {
        Route::put('active', 'active');
        Route::put('inactive', 'inactive');
        Route::get('', 'index');
        Route::get('{id}', 'show');
        Route::post('', 'create');
        Route::put('{id}', 'update');
        Route::delete('', 'delete');
    });
});

Route::controller(ImageController::class)->group(function () {
    Route::prefix('images')->group(function () {
        Route::put('active', 'active');
        Route::put('inactive', 'inactive');
        Route::get('', 'index');
        Route::get('{id}', 'show');
        Route::post('', 'create');
        Route::put('{id}', 'update');
        Route::delete('', 'delete');
    });
});

Route::controller(ProductController::class)->group(function () {
    Route::prefix('products')->group(function () {
        Route::put('active', 'active');
        Route::put('inactive', 'inactive');
        Route::get('', 'index');
        Route::get('{id}', 'show');
        Route::post('', 'create');
        Route::put('{id}', 'update');
        Route::delete('', 'delete');
    });
});


