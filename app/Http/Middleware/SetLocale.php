<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales.
     */
    public const SUPPORTED_LOCALES = ['en', 'ar'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, self::SUPPORTED_LOCALES)) {
            $locale = session('locale', 'ar');
            if (! in_array($locale, self::SUPPORTED_LOCALES)) {
                $locale = 'ar';
            }
        }

        App::setLocale($locale);
        session(['locale' => $locale]);
        URL::defaults(['locale' => $locale]);

        $isRtl = ($locale === 'ar');
        $dir = $isRtl ? 'rtl' : 'ltr';

        View::share('currentLocale', $locale);
        View::share('isRtl', $isRtl);
        View::share('dir', $dir);

        return $next($request);
    }
}
