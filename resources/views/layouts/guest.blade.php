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

<body class="font-sans text-gray-900 antialiased bg-kairouan-warm-cream">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/">
                <img src="{{ asset('images/kairouanhubLogo.PNG') }}" alt="KairouanHub Logo"
                    class="h-24 w-auto drop-shadow-lg hover:scale-105 transition-transform duration-300">
            </a>
        </div>

        <!-- Language Switcher -->
        <div class="mb-4">
            <form method="POST" action="{{ route('lang.switch.post') }}">
                @csrf
                <select name="locale"
                    class="text-sm border-2 border-gray-300 rounded-xl px-4 py-2 bg-white focus:border-terracotta focus:ring-2 focus:ring-terracotta/20 transition-all"
                    onchange="this.form.submit()">
                    <option value="en" @selected(app()->getLocale() === 'en')>EN</option>
                    <option value="fr" @selected(app()->getLocale() === 'fr')>FR</option>
                    <option value="ar" @selected(app()->getLocale() === 'ar')>العربية</option>
                </select>
            </form>
        </div>

        <!-- Form Card -->
        <div class="w-full sm:max-w-md card-mediterranean p-8">
            {{ $slot }}
        </div>

        <!-- Back to Home -->
        <div class="mt-6">
            <a href="{{ route('home') }}"
                class="text-sm text-accent-DEFAULT hover:text-mediterranean-blue font-medium transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للرئيسية / Back to Home
            </a>
        </div>
    </div>
</body>

</html>