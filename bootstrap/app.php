<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\IsEditor;
use App\Http\Middleware\IsAdminOrEditor;
use App\Http\Middleware\CheckRole;


use App\Http\Middleware\CorsMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
        $middleware->api(prepend: [
            CorsMiddleware::class,
        ]);
        $middleware->alias([
            'isAdmin' => IsAdmin::class,
            'isUser' => IsUser::class,
            'isEditor' => IsEditor::class,
            'isAdminOrEditor' => IsAdminOrEditor::class,
            'CheckRole:SUPER-ADMIN,EDITOR' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
