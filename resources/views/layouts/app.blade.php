<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $htmlDir ?? 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [dir="rtl"] {
            direction: rtl;
        }
        
        [dir="rtl"] .rtl\:text-right {
            text-align: right;
        }
        
        [dir="rtl"] .rtl\:ml-auto {
            margin-left: auto;
        }
        
        [dir="rtl"] .rtl\:mr-auto {
            margin-right: auto;
        }
        
        [dir="rtl"] .rtl\:space-x-reverse > * + * {
            margin-left: 0;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('app.navigation.dashboard') }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <!-- Locale Switcher -->
                        <x-locale-switcher />
                        
                        <!-- User Menu -->
                        @auth
                            <div class="relative">
                                <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                </button>
                                
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="ml-4 text-sm text-gray-500 hover:text-gray-700">
                                        {{ __('app.navigation.logout') }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">
                                {{ __('app.navigation.login') }}
                            </a>
                            <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">
                                {{ __('app.navigation.register') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>

