<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = App::getLocale();
    }

    public function getAvailableLocalesProperty(): array
    {
        return [
            'en' => [
                'label' => 'English',
                'native_label' => 'English',
                'icon' => '🇺🇸',
                'rtl' => false,
            ],
            'ar' => [
                'label' => 'Arabic',
                'native_label' => 'العربية',
                'icon' => '🇸🇦',
                'rtl' => true,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
