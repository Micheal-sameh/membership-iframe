<?php

use App\Modules\Membership\Controllers\AuthController;
use App\Modules\Membership\Controllers\MfaController;
use App\Modules\Membership\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Unauthenticated
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// MFA — user has valid credentials but is not fully authenticated yet
Route::prefix('mfa')->name('mfa.')->group(function () {
    Route::get('/challenge',  [MfaController::class, 'challenge'])->name('challenge');
    Route::post('/verify',    [MfaController::class, 'verify'])->name('verify');
    Route::get('/setup',      [MfaController::class, 'setup'])->name('setup');
    Route::post('/setup',     [MfaController::class, 'confirmSetup'])->name('setup.confirm');
    Route::post('/cancel',    [MfaController::class, 'cancel'])->name('cancel');
});

// Authenticated
Route::middleware('membership.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/',         [PortalController::class, 'index'])->name('portal');
});
