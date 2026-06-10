<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CSE Predictor') }} - Intelligent Analytics by SS Labz</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-100 bg-gray-900">
        <div class="min-h-screen bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-800 shadow shadow-gray-900/50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="bg-gray-950 border-t border-gray-800/60 py-6 mt-12 text-center text-xs text-gray-500 font-sans">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-semibold tracking-wider">CSE PREDICTOR</span>
                        <span class="text-gray-600">|</span>
                        <span>Intelligent Market Analytics</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span>© {{ date('Y') }} All rights reserved. Crafted by</span>
                        <a href="https://ss-labz.pages.dev/" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-semibold transition-colors hover:underline">
                            SS Labz
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
