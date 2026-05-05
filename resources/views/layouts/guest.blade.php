<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background-color:#000;">
        <div class="relative min-h-screen overflow-hidden bg-black">
            <div class="pointer-events-none absolute inset-0">
                <img
                    src="https://images.unsplash.com/photo-1646649853703-7645147474ba?auto=format&fit=crop&w=2400&q=60"
                    alt=""
                    class="h-full w-full object-cover opacity-70 blur-md scale-105"
                >
                <div class="absolute inset-0 bg-black/65"></div>
            </div>

            <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                <div class="flex flex-col items-center mb-0">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-blue-500" />
                    </a>
                    <span class="mt-2 text-lg font-semibold text-white">
                        SocialPadel
                    </span>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-6 py-7 bg-black/60 text-white backdrop-blur-xl shadow-xl shadow-black/40 overflow-hidden sm:rounded-2xl ring-1 ring-white/15">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
