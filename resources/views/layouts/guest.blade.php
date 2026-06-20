<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'SmartClass QR') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-50">
        <div class="min-h-screen flex">
            <!-- Left Side: Branding / Visual (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-sky-500 to-indigo-800 p-12 text-white flex-col justify-between relative overflow-hidden">
                <!-- Abstract Blob Shapes for playful feel -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-sky-300 opacity-20 blur-2xl"></div>
                
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-3">
                        <x-application-logo class="w-12 h-12 text-white drop-shadow-md" />
                        <span class="text-2xl font-bold tracking-tight">SmartClass QR</span>
                    </a>
                </div>

                <div class="relative z-10 space-y-6 max-w-lg">
                    <h1 class="text-5xl font-extrabold leading-tight">
                        Absensi <br>Lebih Mudah <br>& Cepat.
                    </h1>
                    <p class="text-indigo-100 text-lg">
                        Tinggalkan cara lama. Gunakan SmartClass QR untuk mencatat kehadiranmu dalam hitungan detik. Cepat, akurat, dan transparan.
                    </p>
                </div>
                
                <div class="relative z-10 text-sm font-medium text-indigo-200">
                    &copy; {{ date('Y') }} SmartClass QR Project. All rights reserved.
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md space-y-8 bg-white p-10 rounded-3xl shadow-xl shadow-slate-200/50">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex justify-center mb-6">
                        <a href="/" class="flex items-center gap-3">
                            <x-application-logo class="w-12 h-12 text-indigo-600" />
                            <span class="text-2xl font-bold text-slate-800">SmartClass QR</span>
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
