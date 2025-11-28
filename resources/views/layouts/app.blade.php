<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title_prefix', __('seo.home_title')) - @yield('title_suffix', __('seo.home_subtitle'))</title>
    <meta name="description"
        content="@yield('description', __('seo.home_description', ['app_name' => config('app.name')]))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="@yield('og_title', View::getSection('title', config('app.name')))" />
    <meta property="og:description"
        content="@yield('og_description', View::getSection('description', __('seo.home_description', ['app_name' => config('app.name')])))" />
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:title" content="@yield('og_title', View::getSection('title', config('app.name')))" />
    <meta property="twitter:description"
        content="@yield('og_description', View::getSection('description', __('seo.home_description', ['app_name' => config('app.name')])))" />
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-kairouan-limestone flex flex-col">
        {{-- Navbar --}}
        @include('layouts.navigation')

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="flex-1">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>

        {{-- Footer --}}
        @include('layouts.footer')
        
        {{-- Chatbot Widget - Available on all pages --}}
        <x-chatbot-widget />
    </div>
    
    {{-- Alpine.js for interactive components --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>