<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is being switched via query parameter
        if ($request->has('locale')) {
            $locale = $request->get('locale');
            $allowedLocales = ['en', 'ar'];

            if (in_array($locale, $allowedLocales)) {
                // Set the locale in session
                Session::put('locale', $locale);
                
                // Set the locale for the current request
                App::setLocale($locale);

                // Set a cookie for Filament to detect RTL
                if ($locale === 'ar') {
                    Cookie::queue('filament_rtl', 'true', 60 * 24 * 365); // 1 year
                    Cookie::queue('html_dir', 'rtl', 60 * 24 * 365); // 1 year
                } else {
                    Cookie::queue('filament_rtl', 'false', 60 * 24 * 365); // 1 year
                    Cookie::queue('html_dir', 'ltr', 60 * 24 * 365); // 1 year
                }
            }
        }

        // Set locale from session if available
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
        }

        // Share locale and direction data with all views
        $currentLocale = App::getLocale();
        $isRTL = $currentLocale === 'ar';
        
        view()->share('currentLocale', $currentLocale);
        view()->share('isRTL', $isRTL);
        view()->share('htmlDir', $isRTL ? 'rtl' : 'ltr');

        return $next($request);
    }
}
