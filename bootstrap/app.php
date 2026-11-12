<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Render terminates TLS at its load balancer and forwards plain HTTP, so trust
        // its X-Forwarded-* headers; otherwise Laravel builds http:// URLs and
        // treats every request as insecure.
        $middleware->trustProxies(at: '*');

        // Laravel 12 ignores app/Http/Kernel.php, so the 'admin' alias that was
        // declared there was never registered. Register it here.
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
