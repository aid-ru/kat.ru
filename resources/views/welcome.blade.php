<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kat.Ru — Каталог бесплатных объявлений</title>

        <!-- Fonts -->
        <style>
        @font-face {
            font-family: 'Figtree';
            src: url(http://localhost:8000/fonts/figtree/Figtree-VariableFont_wght.ttf) format('truetype');
            font-weight: 400 600;
            font-style: normal;
            font-display: swap;
        }
        </style>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased dark:text-gray-200 text-gray-800">
        <div class="min-h-screen dark:bg-black bg-white">
            <nav x-data="{ open: false }" class="dark:bg-black bg-white border-b dark:border-gray-800 border-gray-200">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="/dashboard">
                                    <img src="/images/kat_logo.png" width=100 border=0>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-gray-900 border-b border-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="h2_header">
                        Каталог бесплатных объявлений
                    </h2>
                </div>
            </header>
            
            <!-- Page Content -->
            <main>
                <div class="kat_div_center">
                    <div class="kat_div_margin">
                        <div class="kat_div_bg">
                            <div class="kat_div_inner">
                                <p>
                                    Привет-привет!
                                </p><br>
                                <p>
                                    Данный сайт находится в процессе активной разработки. Разработка идет публично на <a href="https://aid.ru/ch/2">канале проекта Aid.Ru</a>, исходный код проекта открыт. 
                                    Вы можете присоединиться и поучаствовать, либо просто поглазеть на процесс вайб-кодинга ;)
                                </p><br>
                                <p>
                                    Что готово и как посмотреть изнутри?

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 border-sky-700 hover:border-sky-600 border dark:border-blue-500 dark:hover:border-blue-400 rounded-sm leading-normal">
                            Панель
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 border-sky-700 hover:border-sky-600 border dark:border-blue-500 dark:hover:border-blue-400 rounded-sm leading-normal">
                            Вход
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 border-sky-700 hover:border-sky-600 border dark:border-blue-500 dark:hover:border-blue-400 rounded-sm leading-normal">
                            Регистрация
                        </a>
                    @endauth
                </nav>
            @endif

                                </p><br>
                                <p>
                                    Группа в Telegram:&nbsp; <a href="https://t.me/web_aid" target=_blank>@web_aid</a><br>
                                    Чат в Max:&nbsp; <a href="https://max.ru/join/Bt3zSV7hZsi9Za6RmXWpplrITalEFJiIencjNMyRnrY" target=_blank>здесь</a>
                                </p><br>
                                <p>
                                    Основной репозиторий:&nbsp; <a href="https://github.com/aid-ru/kat.ru" target=_blank>на GitHub</a><br>
                                    Местное зеркало:&nbsp; <a href="https://sourcecraft.dev/aid-ru/kat-ru" target=_blank>на SourceCraft</a>
                                </p><br>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="border-t dark:border-gray-800 border-gray-200 py-8 px-6 text-sm text-gray-500">
                <div class="max-w-7xl mx-auto text-center">
                    <div>
                        <p>Kat.Ru — Каталог бесплатных объявлений</p>
                    </div>

                    <div class="text-xs">
                        <p>© {{ date('Y') }} Kat.Ru. Все права защищены.</p>
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>
