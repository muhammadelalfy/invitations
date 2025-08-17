<div class="language-switcher-wrapper" x-data="{ open: false }" @click.away="open = false">
    <div class="language-switcher-container">
        {{-- Dropdown Trigger --}}
        <button 
            type="button"
            @click="open = !open"
            class="language-switcher-trigger"
            :class="{ 'active': open }"
            aria-expanded="false"
            aria-haspopup="true">
            
            <span class="current-language">
                <span class="flag">{{ $this->availableLocales[$currentLocale]['icon'] }}</span>
                <span class="label">{{ $this->availableLocales[$currentLocale]['native_label'] }}</span>
            </span>
            
            <svg class="dropdown-arrow" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="language-dropdown"
            x-cloak>
            
            <div class="language-options">
                @foreach($this->availableLocales as $locale => $config)
                    <form method="GET" action="{{ route('locale.switch', $locale) }}" style="display: inline;">
                        <button 
                            type="submit"
                            @click="open = false"
                            class="language-option {{ $currentLocale === $locale ? 'active' : '' }}"
                            title="{{ $config['label'] }}"
                            onclick="this.style.opacity='0.5'; this.style.pointerEvents='none'; this.innerHTML='🔄 Loading...'; this.form.submit();">
                            
                            <span class="flag">{{ $config['icon'] }}</span>
                            <span class="label">{{ $config['native_label'] }}</span>
                            
                            @if($currentLocale === $locale)
                                <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Inline styles for this component --}}
    <style>
    /* Language Switcher Styles - Theme Responsive */
    .language-switcher-wrapper {
        position: relative;
        z-index: 50;
    }

    /* When in Filament topbar */
    .fi-topbar .language-switcher-wrapper {
        position: relative;
        margin-left: 1rem;
    }

    [dir="rtl"] .fi-topbar .language-switcher-wrapper {
        margin-left: 0;
        margin-right: 1rem;
    }

    .language-switcher-container {
        position: relative;
    }

    .language-switcher-trigger {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: var(--fi-bg);
        border: 1px solid var(--fi-border-color);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.15s ease;
        font-size: 0.875rem;
        font-weight: 500;
        box-shadow: var(--fi-shadow);
        min-width: 120px;
        color: var(--fi-color);
    }

    .language-switcher-trigger:hover {
        background: var(--fi-bg-hover);
        border-color: var(--fi-border-color-hover);
    }

    .language-switcher-trigger.active {
        background: var(--fi-bg-active);
        border-color: var(--fi-border-color-active);
    }

    .current-language {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1;
    }

    .current-language .flag {
        font-size: 1.125rem;
    }

    .current-language .label {
        color: var(--fi-color);
        white-space: nowrap;
    }

    .dropdown-arrow {
        width: 1rem;
        height: 1rem;
        color: var(--fi-muted-color);
        transition: transform 0.15s ease;
        flex-shrink: 0;
    }

    .language-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin-top: 0.25rem;
        background: var(--fi-bg);
        border: 1px solid var(--fi-border-color);
        border-radius: 0.5rem;
        box-shadow: var(--fi-shadow-lg);
        overflow: hidden;
    }

    [dir="rtl"] .language-dropdown {
        left: auto;
        right: 0;
    }

    .language-options {
        padding: 0.25rem;
    }

    .language-options form {
        display: block;
        width: 100%;
    }

    .language-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: none;
        background: transparent;
        cursor: pointer;
        border-radius: 0.375rem;
        transition: all 0.15s ease;
        font-size: 0.875rem;
        text-align: left;
        color: var(--fi-color);
    }

    [dir="rtl"] .language-option {
        text-align: right;
    }

    .language-option:hover {
        background: var(--fi-bg-hover);
    }

    .language-option.active {
        background: var(--fi-primary-500);
        color: var(--fi-primary-on);
    }

    .language-option .flag {
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .language-option .label {
        flex: 1;
        white-space: nowrap;
    }

    .language-option .check-icon {
        width: 1rem;
        height: 1rem;
        color: var(--fi-primary-on);
        flex-shrink: 0;
    }

    /* Fallback styles for when CSS variables are not available */
    .language-switcher-trigger {
        background: #ffffff;
        border-color: #e5e7eb;
        color: #374151;
    }

    .language-dropdown {
        background: #ffffff;
        border-color: #e5e7eb;
    }

    .language-option {
        color: #374151;
    }

    .language-option:hover {
        background: #f3f4f6;
    }

    .language-option.active {
        background: #7c3aed;
        color: #ffffff;
    }

    /* Dark theme fallback */
    .dark .language-switcher-trigger,
    [data-theme="dark"] .language-switcher-trigger {
        background: #1f2937;
        border-color: #374151;
        color: #d1d5db;
    }

    .dark .language-dropdown,
    [data-theme="dark"] .language-dropdown {
        background: #1f2937;
        border-color: #374151;
    }

    .dark .language-option,
    [data-theme="dark"] .language-option {
        color: #d1d5db;
    }

    .dark .language-option:hover,
    [data-theme="dark"] .language-option:hover {
        background: #374151;
    }

    .dark .language-option.active,
    [data-theme="dark"] .language-option.active {
        background: #581c87;
        color: #c4b5fd;
    }

    /* RTL specific adjustments */
    [dir="rtl"] .language-switcher-trigger {
        flex-direction: row-reverse;
    }

    [dir="rtl"] .current-language {
        flex-direction: row-reverse;
    }

    [dir="rtl"] .language-option {
        flex-direction: row-reverse;
    }
    </style>

    {{-- RTL and language handling script --}}
    <script>
    // Ensure RTL is applied immediately
    document.addEventListener('DOMContentLoaded', function() {
        const currentLocale = '{{ $currentLocale }}';
        const htmlElement = document.documentElement;
        
        if (currentLocale === 'ar') {
            htmlElement.setAttribute('dir', 'rtl');
            htmlElement.setAttribute('lang', 'ar');
            document.body.classList.add('rtl');
        } else {
            htmlElement.setAttribute('dir', 'ltr');
            htmlElement.setAttribute('lang', 'en');
            document.body.classList.remove('rtl');
        }
    });

    // Update RTL after page loads (for navigation)
    window.addEventListener('load', function() {
        const currentLocale = '{{ $currentLocale }}';
        const htmlElement = document.documentElement;
        
        if (currentLocale === 'ar') {
            htmlElement.setAttribute('dir', 'rtl');
            htmlElement.setAttribute('lang', 'ar');
            document.body.classList.add('rtl');
        } else {
            htmlElement.setAttribute('dir', 'ltr');
            htmlElement.setAttribute('lang', 'en');
            document.body.classList.remove('rtl');
        }
    });

    // Listen for Filament theme changes
    document.addEventListener('filament-theme-changed', function() {
        // Force a small reflow to ensure CSS variables are updated
        document.body.offsetHeight;
    });

    // Also listen for potential theme toggle events
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest('[data-filament-theme-toggle]')) {
            // Theme toggle clicked, wait a bit then force reflow
            setTimeout(() => {
                document.body.offsetHeight;
            }, 100);
        }
    });
    </script>
</div>