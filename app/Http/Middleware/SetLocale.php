<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = config('app.available_locales', ['fr', 'en', 'es', 'ar']);
        $defaultLocale = config('app.locale', 'fr');

        $locale = $request->session()->get('locale', $defaultLocale);

        if (! in_array($locale, $availableLocales, true)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
