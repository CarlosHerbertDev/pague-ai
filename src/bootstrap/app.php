<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Exceptions\AuthException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->dontReport(AuthException::class);

    $exceptions->shouldRenderJsonWhen(
        fn (Request $request): bool => $request->is('api/*') || $request->expectsJson(),
    );

    $exceptions->render(fn (AuthException $e): JsonResponse => response()->json([
        'code' => $e->error->value,
        'message' => $e->getMessage(),
    ], $e->error->status()));

    $exceptions->render(fn (AuthenticationException $e, Request $request): ?JsonResponse => $request->is('api/*')
        ? response()->json(['code' => 'UNAUTHENTICATED', 'message' => 'Faça login para continuar.'], 401)
        : null);
    })->create();
