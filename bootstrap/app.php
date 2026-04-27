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
    ->withMiddleware(function (Middleware $middleware) {

        // Role-based redirect for already-authenticated users
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            if (!$user) return '/login';

            return match($user->role) {
                'admin', 'staff', 'captain' => '/admin/dashboard',
                'resident'                  => '/portal/dashboard',
                default                     => '/',
            };
        });

        // Register your custom middleware aliases
        $middleware->alias([
            'admin'    => \App\Http\Middleware\AdminMiddleware::class,
            'resident' => \App\Http\Middleware\ResidentMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();