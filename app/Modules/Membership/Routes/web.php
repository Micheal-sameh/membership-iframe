<?php

use App\Modules\Membership\Controllers\AuthController;
use App\Modules\Membership\Controllers\MfaController;
use App\Modules\Membership\Controllers\PortalController;
use App\Modules\Membership\Controllers\ProfileController;
use App\Modules\Membership\Controllers\UserController;
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

    Route::get('/profile',           [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',           [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Admin-only user management
    Route::middleware('role:admin')->prefix('users')->name('users.')->group(function () {
        Route::get('/',                    [UserController::class, 'index'])->name('index');
        Route::get('/create',              [UserController::class, 'create'])->name('create');
        Route::post('/',                   [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit',         [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}',              [UserController::class, 'update'])->name('update');
        Route::put('/{user}/password',     [UserController::class, 'updatePassword'])->name('password');
    });
});
