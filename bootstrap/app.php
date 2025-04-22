<?php

use App\Http\Middleware\ApiSettingMiddleware;
use App\Http\Middleware\CheckMethodRoute;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            \App\Http\Middleware\UserActivity::class,
        ]);
        // web middleware
        $middleware->web([
            \App\Http\Middleware\ChangeLang::class,
            \App\Http\Middleware\UserActivity::class,
        ]);
        // api middleware
        $middleware->api([
            ApiSettingMiddleware::class,
        ]);

        $middleware->alias([
            //
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
