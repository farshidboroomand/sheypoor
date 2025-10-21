<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

$apiV1Namespace = 'Modules\\V1\\Http\\Controllers';

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () use ($apiV1Namespace) {
            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(function () use ($apiV1Namespace) {
                    Route::namespace($apiV1Namespace)
                        ->group(base_path('routes/api_v1.php'));
                });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
