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
        $middleware->redirectTo(
            guests: '/login',
            users: '/admin/dashboard'
        );
        $middleware->alias([
            'perfil' => \App\Http\Middleware\CheckPerfil::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'roteiros-inteligentes/gerar',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
