<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restaurant QR') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 relative overflow-hidden">
        <!-- Desktop Background Decoration -->
        <div class="absolute inset-0 z-0 opacity-10 pointer-events-none hidden sm:block">
            <svg class="h-full w-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="orange" />
            </svg>
        </div>

        <div
            class="w-full sm:max-w-md min-h-screen sm:min-h-[800px] sm:h-auto bg-gray-50 shadow-2xl relative z-10 sm:rounded-[2.5rem] sm:overflow-hidden sm:border-8 sm:border-gray-900">
            <!-- iPhone Notch Mockup (Desktop only decoration) -->
            <div
                class="absolute top-0 left-1/2 transform -translate-x-1/2 w-40 h-6 bg-gray-900 rounded-b-3xl z-50 hidden sm:block">
            </div>

            <div class="h-full overflow-y-auto hide-scrollbar">
                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>