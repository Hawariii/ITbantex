<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>

    <body class="font-sans antialiased">
        <!-- 🔑 WAJIB flex flex-col -->
        <div class="min-h-screen flex flex-col bg-gray-100">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- 🔑 CONTENT HARUS flex-1 -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
<footer class="border-t bg-white">
    <div class="py-2 text-center text-[11px] text-gray-400">
        © {{ date('Y') }} Bantex ·
        Developed by
        <a
            href="https://github.com/Hawariii"
            target="_blank"
            rel="noopener noreferrer"
            class="text-gray-500 font-medium hover:text-gray-700 transition"
        >
            Ahmad Hawari Al Haq
        </a>
        <span class="text-gray-400">(Hawariii)</span>
        · Powered by Laravel
    </div>
</footer>
        </div>
    </body>
</html>
