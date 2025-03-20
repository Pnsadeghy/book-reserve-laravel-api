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
    ->middleware(['auth:sanctum', 'role:user', 'visible'])->group(function () {
        Route::apiResource('books', \App\Http\Controllers\User\BooksController::class)->only(['index', 'show']);

        Route::post('reservations/{reservation}/cancel', [\App\Http\Controllers\User\ReservationController::class, 'cancel'])->name('reservations.cancel');
        Route::apiResource('reservations', \App\Http\Controllers\User\ReservationController::class)->only(['index', 'show']);
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::apiResource('books.bookCopies', \App\Http\Controllers\Admin\BookCopiesController::class)->shallow();
        Route::apiResource('books', \App\Http\Controllers\Admin\BooksController::class);

        Route::apiResource('branches', \App\Http\Controllers\Admin\BranchesController::class);

        Route::post('reservations/{reservation}/complete', [\App\Http\Controllers\Admin\ReservationController::class, 'complete'])->name('reservations.complete');
        Route::apiResource('reservations', \App\Http\Controllers\Admin\ReservationController::class)->only(['index', 'show']);
    });
