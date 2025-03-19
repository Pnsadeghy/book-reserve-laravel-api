<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('logout', 'logout')->name('logout');
        });
    });

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth:sanctum', 'role:user'])->group(function () {
        Route::apiResource('books', \App\Http\Controllers\User\BooksController::class)->only(['index', 'show']);
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::apiResource('books', \App\Http\Controllers\Admin\BooksController::class);
        Route::apiResource('branches', \App\Http\Controllers\Admin\BranchesController::class);
    });
