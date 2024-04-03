<?php

use App\Http\Middleware\OpenTracing;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Kkday\Log\Laravel\Middlewares\LogAfterResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        foreach ($middleware->getMiddlewareGroups() as $groupName => $middlewaresInGroup) {
            $middleware->appendToGroup($groupName, OpenTracing::class);
            $middleware->appendToGroup($groupName, LogAfterResponse::class);
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
