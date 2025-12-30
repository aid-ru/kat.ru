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
        <div class="min-h-screen dark:bg-black bg-white">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-900 border-b border-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
