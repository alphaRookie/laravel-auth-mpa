{{-- LAYOUT FOR GUESS --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- return laravel current language setting --}}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- ensures responsive design on mobile devices --}}
        <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- includes a CSRF token in the page so Laravel forms can validate requests for security --}}

        <title>{{ config('app.name', 'Laravel') }}</title> {{-- sets the page title using the app name from config/app.php (defaults to “Laravel”) --}}

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.bunny.net"> {{-- Preconnect to Bunny CDN for faster font loading --}}
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> {{-- Loads Figtree font in weights 400, 500, 600 --}}

        {{-- Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Loads CSS and JS via Vite (Includes Tailwind CSS styles and JS application) --}}

        {{-- Alpine.js for interactivity --}}
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-r from-indigo-400 to-gray-400"> {{-- The whole background in dashboard --}}
            @include('layouts.guest-navigation') {{-- import the navigation.blade.php, right upper part --}}

            {{-- Page Heading (optional) --}}
            @isset($header) {{-- $header only exist if we define <x-slot name="header"> --}}
                <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 "> {{-- max-w-7xl mx-auto make the text&image sticks in the middle when zoom in/out --}}
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main>
                <div class="mx-auto px-4 sm:px-6 lg:px-8"> {{-- So any form wont stretch horizontally --}}
                    {{ $slot }} {{-- It's a placeholder, so whatever we passed inside <x-app-layout> or <x-guest-layout> be injected here --}}
                </div> 

                {{-- Fullwidth slot (no wrapper) --}}
                {{ $fullwidth ?? '' }}
            </main>
        </div>
    </body>
</html>

{{-- Tambah "max-w-3xl" didalam class slot biar kotaknya ditengah kayak sebelumnya --}}