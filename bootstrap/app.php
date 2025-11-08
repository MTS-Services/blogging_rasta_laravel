<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminVerifyMiddleware;
use App\Http\Middleware\UserVerifyMiddleware;
use App\Http\Middleware\SetLocaleMiddleware as MultiLangSet;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PROTO);
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'adminVerify' => AdminVerifyMiddleware::class,
            'userVerify' => UserVerifyMiddleware::class,
        ]);
        $middleware->web(MultiLangSet::class);
        $middleware->api(MultiLangSet::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
