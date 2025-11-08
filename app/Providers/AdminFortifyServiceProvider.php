<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;

class AdminFortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Override 2FA login response for admin
        $this->app->singleton(TwoFactorLoginResponse::class, function () {
            return new class implements TwoFactorLoginResponse {
                public function toResponse($request)
                {
                    if ($request->user('admin')) {
                        return redirect()->intended(config('fortify-admin.home'));
                    }
                    return redirect()->intended(config('fortify.home'));
                }
            };
        });
    }

    public function boot(): void
    {
        $this->configureAdminRoutes();
        $this->configureAdminRateLimiting();
    }

    protected function configureAdminRoutes(): void
    {
        Route::group([
            'domain' => config('fortify-admin.domain', null),
            'prefix' => config('fortify-admin.prefix', 'admin'),
            'middleware' => config('fortify-admin.middleware', ['web']),
        ], function () {
            $this->loadRoutesFrom(base_path('routes/fortify-admin.php'));
        });
    }

    protected function configureAdminRateLimiting(): void
    {
        RateLimiter::for('admin-two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}