<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::middleware('throttle:auth')->group(function (): void {
        Route::post('register', [AuthController::class, 'register']);
        // Route::post('login', [AuthController::class, 'login']);
        // Route::post('google/exchange', [GoogleAuthController::class, 'exchange']);
        Route::post('email/resend', [EmailVerificationController::class, 'resend']);
        // Route::post('forgot-password', [PasswordController::class, 'forgot']);
        // Route::post('reset-password', [PasswordController::class, 'reset']);
    });

    // Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('throttle:6,1')
        ->name('verification.verify');

    // Route::middleware('auth:api')->group(function (): void {
    //     Route::get('me', [AuthController::class, 'me']);
    //     Route::post('logout', [AuthController::class, 'logout']);
    // });
});