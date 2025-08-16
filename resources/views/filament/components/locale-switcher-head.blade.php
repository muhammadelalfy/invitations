<style>
/* RTL Support for Filament Panels */
[dir="rtl"] {
    direction: rtl;
}

[dir="rtl"] .filament-main {
    direction: rtl;
}

[dir="rtl"] .filament-sidebar {
    direction: rtl;
}

[dir="rtl"] .filament-main-content {
    direction: rtl;
}

[dir="rtl"] .filament-header {
    direction: rtl;
}

[dir="rtl"] .filament-topbar {
    direction: rtl;
}

/* Locale Switcher Styles */
.locale-switcher-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 9999;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    display: flex;
    gap: 0.5rem;
}

.locale-switcher-container [dir="rtl"] {
    right: auto;
    left: 1rem;
}

.locale-switcher-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.locale-switcher-btn.active {
    background-color: #8b5cf6;
    color: white;
}

.locale-switcher-btn:not(.active) {
    color: #374151;
    background-color: transparent;
}

.locale-switcher-btn:not(.active):hover {
    background-color: #f3f4f6;
}

.locale-switcher-btn .flag {
    font-size: 1.25rem;
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

/* RTL Support for locale switcher */
[dir="rtl"] .locale-switcher-container {
    left: 1rem;
    right: auto;
}

[dir="rtl"] .locale-switcher-btn {
    flex-direction: row-reverse;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .locale-switcher-container {
        background: #1f2937;
        border-color: #374151;
    }
    
    .locale-switcher-btn:not(.active) {
        color: #d1d5db;
    }
    
    .locale-switcher-btn:not(.active):hover {
        background-color: #374151;
    }
}
</style>

<div class="locale-switcher-container" id="locale-switcher">
    @php
        $currentLocale = app()->getLocale();
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
        
        // Detect which panel we're in and construct the URL directly
        $currentPath = request()->path();
        $isSuperAdmin = str_contains($currentPath, 'super-admin');
        $isAdmin = str_contains($currentPath, 'admin');
        
        if ($isSuperAdmin) {
            $localeUrl = '/super-admin/locale-switch';
        } elseif ($isAdmin) {
            $localeUrl = '/admin/locale-switch';
        } else {
            $localeUrl = '/locale/en'; // fallback to web route
        }
    @endphp

    @foreach($locales as $locale => $config)
        <button onclick="switchLocale('{{ $locale }}')" 
           class="locale-switcher-btn {{ $currentLocale === $locale ? 'active' : '' }}"
           title="{{ $config['label'] }}">
            <span class="flag">{{ $config['icon'] }}</span>
            <span class="label">{{ $config['label'] }}</span>
        </button>
    @endforeach
</div>

<script>
// Set the HTML dir attribute immediately when the script loads
(function() {
    const currentLocale = '{{ $currentLocale }}';
    const htmlElement = document.documentElement;
    
    if (currentLocale === 'ar') {
        htmlElement.setAttribute('dir', 'rtl');
    } else {
        htmlElement.setAttribute('dir', 'ltr');
    }
})();

// Also set it when DOM is ready (backup)
document.addEventListener('DOMContentLoaded', function() {
    const currentLocale = '{{ $currentLocale }}';
    const htmlElement = document.documentElement;
    
    if (currentLocale === 'ar') {
        htmlElement.setAttribute('dir', 'rtl');
    } else {
        htmlElement.setAttribute('dir', 'ltr');
    }
});

// Handle locale switching
function switchLocale(locale) {
    // Show loading state
    const btn = event.target.closest('.locale-switcher-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '🔄';
    btn.style.pointerEvents = 'none';
    
    // Redirect to the locale switch page
    window.location.href = '{{ $localeUrl }}?action=switch&locale=' + locale;
}
</script>
