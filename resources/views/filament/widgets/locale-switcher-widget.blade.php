<x-filament-widgets::widget>
    {{-- Include RTL Support Component --}}
    <x-rtl-support :locale="app()->getLocale()" />
    
    @livewire('language-switcher')
</x-filament-widgets::widget>
