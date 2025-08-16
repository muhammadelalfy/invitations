<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set locale from session or cookie
        $this->setLocaleFromSessionOrCookie();
        
        // Share locale data with all views
        $this->shareLocaleData();
    }

    /**
     * Set locale from session or cookie
     */
    protected function setLocaleFromSessionOrCookie(): void
    {
        // Check session first
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
            return;
        }

        // Check cookie if session doesn't have locale
        if (Cookie::has('html_dir')) {
            $htmlDir = Cookie::get('html_dir');
            $locale = $htmlDir === 'rtl' ? 'ar' : 'en';
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
    }

    /**
     * Share locale data with all views
     */
    protected function shareLocaleData(): void
    {
        $currentLocale = App::getLocale();
        $isRTL = $currentLocale === 'ar';
        $htmlDir = $isRTL ? 'rtl' : 'ltr';

        View::share('currentLocale', $currentLocale);
        View::share('isRTL', $isRTL);
        View::share('htmlDir', $htmlDir);
        View::share('availableLocales', [
            'en' => [
                'label' => __('app.languages.english'),
                'icon' => '🇺🇸',
                'rtl' => false,
            ],
            'ar' => [
                'label' => __('app.languages.arabic'),
                'icon' => '🇸🇦',
                'rtl' => true,
            ],
        ]);
    }
}

