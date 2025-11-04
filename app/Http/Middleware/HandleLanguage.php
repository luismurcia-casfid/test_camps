<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class HandleLanguage
{
    /**
     * Los idiomas soportados por la aplicación.
     */
    protected array $supportedLocales = ['es', 'en', 'ca'];

    /**
     * El idioma por defecto.
     */
    protected string $defaultLocale = 'es';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el idioma de la cookie
        $locale = $request->cookie('language', $this->defaultLocale);

        // Validar que el idioma es soportado
        if (! in_array($locale, $this->supportedLocales)) {
            $locale = $this->defaultLocale;
        }

        // Establecer el idioma en Laravel
        App::setLocale($locale);

        return $next($request);
    }
}
