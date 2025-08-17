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
            // Main layout elements - only for non-interactive elements
            const main = document.querySelector('.filament-main, .fi-main');
            const header = document.querySelector('.filament-header, .fi-header');
            const topbar = document.querySelector('.filament-topbar, .fi-topbar');
            
            // Apply RTL direction to main elements (excluding sidebar and navigation)
            [main, header, topbar].forEach(el => {
                if (el) el.style.direction = 'rtl';
            });
            
            // Filament v3 specific selectors - only for non-interactive elements
            const filamentElements = document.querySelectorAll(
                '.fi-main-ctn, .fi-topbar, .fi-ta-content, ' +
                '.fi-form, .fi-section, .fi-table, .fi-modal, ' +
                '.fi-dropdown, .fi-btn-group, .fi-input-wrapper'
            );
            
            filamentElements.forEach(el => {
                el.style.direction = 'rtl';
            });
            
            // Fix sidebar navigation items - only text alignment, not direction
            const sidebarNavItems = document.querySelectorAll('.fi-sidebar-nav-item-button, .fi-sidebar-nav-item-label');
            sidebarNavItems.forEach(item => {
                item.style.textAlign = 'right';
                // Don't override direction - let Filament handle it
            });
            
            // Simple RTL positioning for sidebar navigation groups
            const adjustSidebarGroups = () => {
                const groups = document.querySelectorAll('.fi-sidebar-nav-group');
                groups.forEach(group => {
                    const groupButton = group.querySelector('.fi-sidebar-nav-group-button');
                    if (groupButton) {
                        // Don't override direction - let Filament handle everything
                        // Only apply RTL class for CSS targeting if needed
                        groupButton.classList.add('rtl-group');
                    }
                });
            };
            
            // Run simple sidebar adjustment
            adjustSidebarGroups();
            
            // Fix text alignment for forms and inputs
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], textarea, select');
            inputs.forEach(input => {
                input.style.textAlign = 'right';
                // Don't override direction - let Filament handle it
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
        
        // Setup sidebar groups on various events
        document.addEventListener('livewire:load', adjustSidebarGroups);
        document.addEventListener('livewire:navigated', adjustSidebarGroups);
        document.addEventListener('DOMContentLoaded', adjustSidebarGroups);
        
        // Also run after a delay to catch dynamically loaded content
        setTimeout(adjustSidebarGroups, 100);
        setTimeout(adjustSidebarGroups, 500);

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

/* Legacy Filament selectors - only for non-interactive elements */
[dir="rtl"] .filament-main,
[dir="rtl"] .filament-main-content,
[dir="rtl"] .filament-header,
[dir="rtl"] .filament-topbar {
    direction: rtl;
}

/* Filament v3 selectors - only for non-interactive elements */
[dir="rtl"] .fi-main,
[dir="rtl"] .fi-main-ctn,
[dir="rtl"] .fi-header,
[dir="rtl"] .fi-topbar,
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
    /* Don't override direction - let Filament handle it */
}

/* Filament input wrappers */
[dir="rtl"] .fi-input-wrapper,
[dir="rtl"] .fi-input,
[dir="rtl"] .fi-textarea,
[dir="rtl"] .fi-select {
    /* Don't override direction - let Filament handle it */
}

[dir="rtl"] .fi-input-wrapper input,
[dir="rtl"] .fi-input-wrapper textarea,
[dir="rtl"] .fi-input-wrapper select {
    text-align: right;
}

/* Buttons and actions */
[dir="rtl"] .fi-btn-group {
    /* Don't override flex-direction - let Filament handle it */
}

[dir="rtl"] .fi-btn {
    /* Don't override direction - let Filament handle it */
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
    /* Don't override direction - let Filament handle it */
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
    /* Don't override flex-direction - let Filament handle it */
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
    /* Don't override direction - let Filament handle it */
}

[dir="rtl"] .fi-breadcrumb-item::after {
    transform: scaleX(-1);
}

/* Page header */
[dir="rtl"] .fi-page-header {
    /* Don't override direction - let Filament handle it */
}

/* Cards and panels */
[dir="rtl"] .fi-card,
[dir="rtl"] .fi-section-content {
    /* Don't override direction - let Filament handle it */
}

/* Widget adjustments */
[dir="rtl"] .fi-widget {
    /* Don't override direction - let Filament handle it */
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
    /* Don't override direction - let Filament handle it */
}

/* Fix for Filament notifications */
[dir="rtl"] .fi-notification {
    /* Don't override direction - let Filament handle it */
    text-align: right;
}

/* Simple RTL positioning for sidebar groups - don't override direction */
[dir="rtl"] .fi-sidebar-nav-group-button {
    /* Let Filament handle all direction and rotation */
}



</style>

