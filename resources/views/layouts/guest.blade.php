<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Kat.Ru — Каталог бесплатных объявлений')</title>

        <!-- Fonts -->
        <style>
        @font-face {
            font-family: 'Figtree';
            src: url({{ asset('/fonts/figtree/Figtree-VariableFont_wght.ttf') }}) format('truetype');
            font-weight: 400 600;
            font-style: normal;
            font-display: swap;
        }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:text-gray-200 text-gray-800">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 dark:bg-black bg-white">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 dark:bg-gray-800 bg-gray-200 overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
