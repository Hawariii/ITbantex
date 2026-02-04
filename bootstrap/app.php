<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    /*
    |--------------------------------------------------------------------------
    | ROUTING
    |--------------------------------------------------------------------------
    */
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARE
    |--------------------------------------------------------------------------
    | Daftarkan middleware custom lu disini
    */
    ->withMiddleware(function (Middleware $middleware) {

        // Alias middleware admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })

    /*
    |--------------------------------------------------------------------------
    | EXCEPTIONS
    |--------------------------------------------------------------------------
    | Laravel butuh Handler untuk jalan normal
    */
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
