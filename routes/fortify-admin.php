<?php

use App\Http\Controllers\Auth\Admin\TwoFactorAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;

// Two-Factor Authentication Challenge (for login)
Route::get('admin/two-factor-challenge', function () {
    return view('frontend.auth.admin.two-factor-challenge');
})->middleware(['guest:admin'])->name('admin.two-factor.login');

Route::post('admin/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
    ->middleware(['guest:admin', 'throttle:6,1'])
    ->name('admin.two-factor.login.store');
// 2FA Management Routes (Protected)
Route::middleware(['auth:admin'])->group(function () {
    // Enable 2FA
    Route::post('/admin/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
        ->name('admin.two-factor.enable');

    // Confirm 2FA
    Route::post('/admin/confirmed-two-factor-authentication', function (Illuminate\Http\Request $request) {
        $user = $request->user('admin');
        
        $confirmed = app(\Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication::class)(
            $user,
            $request->input('code')
        );

        if (!$confirmed) {
            return back()->withErrors(['code' => 'The provided code was invalid.']);
        }

        return back()->with('status', 'two-factor-authentication-confirmed');
    })->name('admin.two-factor.confirm');

    // Disable 2FA
    Route::delete('/admin/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
        ->name('admin.two-factor.disable');

    // QR Code
    Route::get('/admin/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
        ->name('admin.two-factor.qr-code');

    // Secret Key
    Route::get('/admin/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
        ->name('admin.two-factor.secret-key');

    // Recovery Codes
    Route::get('/admin/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
        ->name('admin.two-factor.recovery-codes');

    Route::post('/admin/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
        ->name('admin.two-factor.recovery-codes.store');
});

Route::middleware(['auth:web'])->group(function () {
    // Enable 2FA
    Route::post('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
        ->name('user.two-factor.enable');

    // Confirm 2FA
    Route::post('user/confirmed-two-factor-authentication', function (Illuminate\Http\Request $request) {
        $user = $request->user();
        
        $confirmed = app(\Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication::class)(
            $user,
            $request->input('code')
        );

        if (!$confirmed) {
            return back()->withErrors(['code' => 'The provided code was invalid.']);
        }

        return back()->with('status', 'two-factor-authentication-confirmed');
    })->name('user.two-factor.confirm');

    // Disable 2FA
    Route::delete('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
        ->name('user.two-factor.disable');

    // QR Code
    Route::get('user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
        ->name('user.two-factor.qr-code');

    // Secret Key
    Route::get('user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
        ->name('user.two-factor.secret-key');

    // Recovery Codes
    Route::get('user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
        ->name('user.two-factor.recovery-codes');

    Route::post('user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
        ->name('user.two-factor.recovery-codes.store');
});