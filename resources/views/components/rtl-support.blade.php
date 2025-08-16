@props(['locale' => null])

@php
    $currentLocale = $locale ?? app()->getLocale();
    $isRTL = $currentLocale === 'ar';
    $htmlDir = $isRTL ? 'rtl' : 'ltr';
@endphp

<script>
// RTL Support Script
(function() {
    'use strict';
    
    // Set HTML attributes
    const htmlElement = document.documentElement;
    htmlElement.setAttribute('dir', '{{ $htmlDir }}');
    htmlElement.setAttribute('lang', '{{ $currentLocale }}');
    
    // RTL specific adjustments
    if ('{{ $isRTL }}' === '1') {
        // Add RTL class to body
        document.body.classList.add('rtl');
        
        // Adjust Filament panel elements
        const adjustRTL = () => {
            // Main layout elements
            const sidebar = document.querySelector('.filament-sidebar, .fi-sidebar');
            const main = document.querySelector('.filament-main, .fi-main');
            const header = document.querySelector('.filament-header, .fi-header');
            const topbar = document.querySelector('.filament-topbar, .fi-topbar');
            const navigation = document.querySelector('.filament-navigation, .fi-navigation');
            
            // Apply RTL direction to main elements
            [sidebar, main, header, topbar, navigation].forEach(el => {
                if (el) el.style.direction = 'rtl';
            });
            
            // Filament v3 specific selectors
            const filamentElements = document.querySelectorAll(
                '.fi-main-ctn, .fi-sidebar-nav, .fi-topbar, .fi-ta-content, ' +
                '.fi-form, .fi-section, .fi-table, .fi-modal, ' +
                '.fi-dropdown, .fi-btn-group, .fi-input-wrapper, ' +
                '.fi-sidebar-nav-item, .fi-sidebar-nav-group'
            );
            
            filamentElements.forEach(el => {
                el.style.direction = 'rtl';
            });
            
            // Fix sidebar navigation items
            const sidebarNavItems = document.querySelectorAll('.fi-sidebar-nav-item-button, .fi-sidebar-nav-item-label');
            sidebarNavItems.forEach(item => {
                item.style.textAlign = 'right';
                item.style.direction = 'rtl';
            });
            
            // Fix text alignment for forms and inputs
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], textarea, select');
            inputs.forEach(input => {
                input.style.textAlign = 'right';
                input.style.direction = 'rtl';
            });
        };
        
        // Run on load and after Livewire updates
        adjustRTL();
        document.addEventListener('livewire:load', adjustRTL);
        document.addEventListener('livewire:navigated', adjustRTL);
        document.addEventListener('DOMContentLoaded', adjustRTL);
        
        // Also run after a delay to catch dynamically loaded content
        setTimeout(adjustRTL, 100);
        setTimeout(adjustRTL, 500);
    } else {
        // Remove RTL class if switching to LTR
        document.body.classList.remove('rtl');
    }
})();

// Listen for locale changes
document.addEventListener('livewire:navigated', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const locale = urlParams.get('locale');
    
    if (locale) {
        const htmlElement = document.documentElement;
        const isRTL = locale === 'ar';
        
        htmlElement.setAttribute('dir', isRTL ? 'rtl' : 'ltr');
        htmlElement.setAttribute('lang', locale);
        
        if (isRTL) {
            document.body.classList.add('rtl');
        } else {
            document.body.classList.remove('rtl');
        }
    }
});
</script>

<style>
/* RTL Support Styles */
[dir="rtl"] {
    direction: rtl;
}

/* Legacy Filament selectors */
[dir="rtl"] .filament-main,
[dir="rtl"] .filament-sidebar,
[dir="rtl"] .filament-main-content,
[dir="rtl"] .filament-header,
[dir="rtl"] .filament-topbar,
[dir="rtl"] .filament-navigation {
    direction: rtl;
}

/* Filament v3 selectors */
[dir="rtl"] .fi-main,
[dir="rtl"] .fi-sidebar,
[dir="rtl"] .fi-main-ctn,
[dir="rtl"] .fi-header,
[dir="rtl"] .fi-topbar,
[dir="rtl"] .fi-navigation,
[dir="rtl"] .fi-sidebar-nav,
[dir="rtl"] .fi-ta-content,
[dir="rtl"] .fi-form,
[dir="rtl"] .fi-section,
[dir="rtl"] .fi-table,
[dir="rtl"] .fi-modal,
[dir="rtl"] .fi-dropdown,
[dir="rtl"] .fi-btn-group {
    direction: rtl;
}

/* Form inputs RTL support */
[dir="rtl"] input[type="text"],
[dir="rtl"] input[type="email"],
[dir="rtl"] input[type="password"],
[dir="rtl"] input[type="number"],
[dir="rtl"] input[type="search"],
[dir="rtl"] textarea,
[dir="rtl"] select {
    text-align: right;
    direction: rtl;
}

/* Filament input wrappers */
[dir="rtl"] .fi-input-wrapper,
[dir="rtl"] .fi-input,
[dir="rtl"] .fi-textarea,
[dir="rtl"] .fi-select {
    direction: rtl;
}

[dir="rtl"] .fi-input-wrapper input,
[dir="rtl"] .fi-input-wrapper textarea,
[dir="rtl"] .fi-input-wrapper select {
    text-align: right;
}

/* Buttons and actions */
[dir="rtl"] .fi-btn-group {
    flex-direction: row-reverse;
}

[dir="rtl"] .fi-btn {
    direction: rtl;
}

/* Tables */
[dir="rtl"] .fi-table th,
[dir="rtl"] .fi-table td {
    text-align: right;
}

[dir="rtl"] .fi-table-header-cell,
[dir="rtl"] .fi-table-cell {
    text-align: right;
}

/* Navigation adjustments */
[dir="rtl"] .fi-sidebar-nav,
[dir="rtl"] .fi-sidebar-nav-item {
    direction: rtl;
}

[dir="rtl"] .fi-sidebar-nav-item-icon {
    margin-left: 0.75rem;
    margin-right: 0;
}

[dir="rtl"] .fi-sidebar-nav-item-label {
    text-align: right;
}

/* Sidebar adjustments for RTL */
[dir="rtl"] .fi-sidebar {
    left: auto;
    right: 0;
}

[dir="rtl"] .fi-main-ctn {
    margin-right: 0;
    margin-left: auto;
}

/* Sidebar navigation icons and text */
[dir="rtl"] .fi-sidebar-nav-group-items,
[dir="rtl"] .fi-sidebar-nav-item {
    text-align: right;
}

[dir="rtl"] .fi-sidebar-nav-item-button {
    flex-direction: row-reverse;
}

[dir="rtl"] .fi-sidebar-nav-item-badge {
    margin-left: 0;
    margin-right: auto;
}

/* Sidebar collapse button */
[dir="rtl"] .fi-sidebar-collapse-button {
    left: auto;
    right: 1rem;
}

/* Modal and dropdown positioning */
[dir="rtl"] .fi-dropdown-panel {
    left: auto;
    right: 0;
}

/* RTL specific spacing adjustments */
[dir="rtl"] .rtl\:space-x-reverse > * + * {
    margin-left: 0;
    margin-right: 0.5rem;
}

[dir="rtl"] .rtl\:ml-auto {
    margin-left: auto;
}

[dir="rtl"] .rtl\:mr-auto {
    margin-right: auto;
}

[dir="rtl"] .rtl\:text-right {
    text-align: right;
}

[dir="rtl"] .rtl\:float-right {
    float: right;
}

[dir="rtl"] .rtl\:float-left {
    float: left;
}

/* Breadcrumbs */
[dir="rtl"] .fi-breadcrumbs {
    direction: rtl;
}

[dir="rtl"] .fi-breadcrumb-item::after {
    transform: scaleX(-1);
}

/* Page header */
[dir="rtl"] .fi-page-header {
    direction: rtl;
}

/* Cards and panels */
[dir="rtl"] .fi-card,
[dir="rtl"] .fi-section-content {
    direction: rtl;
}

/* Widget adjustments */
[dir="rtl"] .fi-widget {
    direction: rtl;
}

/* RTL Support for locale switcher */
[dir="rtl"] .locale-switcher-container,
[dir="rtl"] .language-switcher-wrapper {
    left: 1rem;
    right: auto;
}

[dir="rtl"] .locale-switcher-btn,
[dir="rtl"] .language-option {
    flex-direction: row-reverse;
}

/* Fix for Filament badges */
[dir="rtl"] .fi-badge {
    direction: rtl;
}

/* Fix for Filament notifications */
[dir="rtl"] .fi-notification {
    direction: rtl;
    text-align: right;
}
</style>

