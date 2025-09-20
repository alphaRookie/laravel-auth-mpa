{{-- LAYOUT FOR LOGGED-IN USER --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- return laravel current language setting --}}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100"> {{-- The whole background in dashboard --}}
            @include('layouts.user-navigation') {{-- import the navigation.blade.php --}}

            {{-- Page Heading (optional) --}}
            @isset($header) {{-- $header only exist if we define <x-slot name="header"> in child file (this case:dashboard.blade) --}}
                <header class="bg-gray-200 shadow"> {{-- The bakcground where the 'Dashboard' word placed --}}
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main>
                {{ $slot }} {{-- It's a placeholder, so whatever we passed inside <x-app-layout> in child file will be injected here --}}
            </main>
        </div>
    </body>
</html>
