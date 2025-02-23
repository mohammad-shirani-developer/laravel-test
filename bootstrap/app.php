<?php

use App\Http\Middleware\CheckUserIsAdmin;
use App\Http\Middleware\UserActivity;
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
        app('router')->aliasMiddleware('admin', CheckUserIsAdmin::class);
        $middleware->append(UserActivity::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
