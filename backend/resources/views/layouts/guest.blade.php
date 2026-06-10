<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CSE Predictor') }} - SS Labz</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 bg-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="flex flex-col items-center mb-6">
                <a href="/">
                    <x-application-logo class="w-16 h-16 fill-current text-emerald-400 drop-shadow-[0_0_15px_rgba(52,211,153,0.4)] hover:scale-105 transition-transform" />
                </a>
                <h2 class="mt-4 text-xl font-bold tracking-tight text-white">CSE Predictor</h2>
                <p class="text-xs text-gray-500 mt-1">
                    A product of <a href="https://ss-labz.pages.dev/" target="_blank" class="text-emerald-500 hover:text-emerald-400 hover:underline font-semibold transition-colors">SS Labz</a>
                </p>
            </div>

            <div class="w-full sm:max-w-md px-8 py-6 bg-gray-800/80 border border-gray-700/50 shadow-xl backdrop-blur-xl rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
