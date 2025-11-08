<?php

use App\Http\Controllers\Auth\Admin\TwoFactorController as AdminTwoFactorController;
use App\Http\Controllers\Auth\Admin\TwoFactorAuthenticatedSessionController as AdminTwoFactorSessionController;
use App\Http\Controllers\Auth\User\Socialite\AppleAuthController;
use App\Http\Controllers\Auth\User\Socialite\FacebookController;
use App\Http\Controllers\Auth\User\Socialite\GoogleAuthController;
use App\Http\Controllers\Auth\User\TwoFactorAuthenticatedSessionController as UserTwoFactorSessionController;
use App\Http\Controllers\Auth\User\VerifyEmailController as UserVerifyEmailController;
use App\Http\Controllers\Auth\Admin\VerifyEmailController as AdminVerifyEmailController;
use App\Http\Controllers\Auth\User\TwoFactorController as UserTwoFactorController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

// User Auth Routes
Route::middleware('guest:web')->group(function () {
    Route::get('login', function () {
        return view('frontend.auth.user.login');
    })->name('login');
    
    Route::get('register', function () {
        return view('frontend.auth.user.register');
    })->name('register');
    
    Route::get('forgot-password', function () {
        return view('frontend.auth.user.forgot-password');
    })->name('password.request');
    
    // User Two-Factor Challenge
    Route::get('two-factor-challenge', function () {
        if (!session()->has('login.id')) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login first.']);
        }
        return view('frontend.auth.user.two-factor-challenge');
    })->name('two-factor.login');
    
    Route::post('two-factor-challenge', [UserTwoFactorSessionController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('two-factor.login.store');
    
    Route::get('reset-password/{token}', function ($token) {
        return view('frontend.auth.user.reset-password', compact('token'));
    })->name('password.reset');
    
    Route::get('password-reset/verify-otp', function () {
        return view('frontend.auth.user.verify-reset-otp');
    })->middleware(['throttle:6,1'])->name('verify-reset-otp');
});

Route::middleware('auth:web')->group(function () {
    Route::get('verify-email', function () {
        return view('frontend.auth.user.verify-email');
    })->name('verification.notice');
    
    Route::get('verify-otp', function () {
        return view('frontend.auth.user.verify-otp');
    })->name('verify-otp')->middleware(['throttle:6,1']);

    Route::get('verify-email/{id}/{hash}', UserVerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
        
    // User 2FA Management
    Route::prefix('user/profile/two-factor')->name('two-factor.')->group(function () {
        Route::get('/', [UserTwoFactorController::class, 'index'])->name('index');
        Route::get('/qr-code', [UserTwoFactorController::class, 'show'])->name('qr-code');
        Route::get('/recovery-codes', [UserTwoFactorController::class, 'codes'])->name('recovery-codes');
    });
});

Route::post('logout', Logout::class)->name('logout');

// Admin Auth Routes 
Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', function () {
            return view('frontend.auth.admin.login');
        })->name('login');
        
        Route::get('forgot-password', function () {
            return view('frontend.auth.admin.forgot-password');
        })->name('password.request');
        
        Route::get('password-reset/verify-otp', function () {
            return view('frontend.auth.admin.verify-reset-otp');
        })->name('reset.verify-otp')->middleware(['throttle:6,1']);
        
        Route::get('reset-password/{token}', function (string $token) {
            return view('frontend.auth.admin.reset-password', compact('token'));
        })->name('password.reset');
        
        // Admin Two-Factor Challenge
        Route::get('two-factor-challenge', function () {
            if (!session()->has('login.id')) {
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'Please login first.']);
            }
            return view('frontend.auth.admin.two-factor-challenge');
        })->name('two-factor.login');
        
        // Route::post('two-factor-challenge', [AdminTwoFactorSessionController::class, 'store'])
        //     ->middleware(['throttle:6,1'])
        //     ->name('two-factor.login.store');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('verify-email', function () {
            return view('frontend.auth.admin.verify-email');
        })->name('verification.notice');
        
        Route::get('verify-otp', function () {
            return view('frontend.auth.admin.verify-otp');
        })->name('verify-otp')->middleware(['throttle:6,1']);

        Route::prefix('profile/two-factor')->name('two-factor.')->group(function () {
            Route::get('/', [AdminTwoFactorController::class, 'index'])->name('index');
            Route::get('/qr-code', [AdminTwoFactorController::class, 'show'])->name('qr-code');
            Route::get('/recovery-codes', [AdminTwoFactorController::class, 'codes'])->name('recovery-codes');
        });

        Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
    });

    Route::post('logout', Logout::class)->name('logout');
});


Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

Route::get('/auth/apple', [AppleAuthController::class, 'redirect'])->name('apple.login');
Route::get('/auth/apple/callback', [AppleAuthController::class, 'callback'])->name('apple.callback');