<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class LocaleSwitcher extends Component
{
    public function render()
    {
        $currentLocale = App::getLocale();
        $locales = [
            'en' => [
                'label' => 'English',
                'icon' => '🇺🇸',
                'rtl' => false,
            ],
            'ar' => [
                'label' => 'العربية',
                'icon' => '🇸🇦',
                'rtl' => true,
            ],
        ];

        return view('components.locale-switcher', compact('currentLocale', 'locales'));
    }
}


