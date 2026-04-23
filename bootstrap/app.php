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
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\ShareActiveTheme::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':60,1', // Limit to 60 requests per minute
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle Spatie Permission exceptions to prevent redirect loops
        $exceptions->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have the required authorization.',
                    'required_permissions' => $e->getRequiredPermissions(),
                    'required_roles' => $e->getRequiredRoles(),
                ], 403);
            }

            // For web requests, redirect back with error instead of causing loops
            return redirect()->back()
                ->with('error', 'Access Denied: ' . $e->getMessage())
                ->with('error_title', 'Unauthorized');
        });

        // Handle 403 Forbidden
        $exceptions->renderable(function (\Illuminate\Http\Exceptions\HttpResponseException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            return redirect()->route('portal')
                ->with('error', 'You do not have permission to access that resource.');
        });
    })->create();
