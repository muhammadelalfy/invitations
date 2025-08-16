<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class LocaleSwitcherWidget extends Widget
{
    protected static string $view = 'filament.widgets.locale-switcher-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static bool $isLazy = false;
    
    public static function canView(): bool
    {
        return true;
    }
}
