<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\HandleLanguage;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state', 'language']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleLanguage::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Establecer el locale antes de renderizar páginas de error
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            // Obtener el idioma de la cookie
            $locale = $request->cookie('language', config('app.locale', 'es'));

            // Validar que el idioma es soportado
            $supportedLocales = ['es', 'en', 'ca'];
            if (in_array($locale, $supportedLocales)) {
                app()->setLocale($locale);
            }

            // Dejar que Laravel maneje el renderizado normal
            return null;
        });
    })->create();
