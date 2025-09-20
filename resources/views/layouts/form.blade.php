{{-- LAYOUT FOR GUESS --}}
{{-- Defined here: app\View\Components\FormLayout.php --}}

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
        <main class="min-h-screen">
            <div class=" mx-auto ">
                {{ $slot }}
            </div>
        </main>
    </body>
</html> 
