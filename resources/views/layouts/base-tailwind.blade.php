<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="@if(dark_theme())dark@else light@endif">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">

    <!-- Scripts -->
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen bg-base-100">
<div id="app" class="flex-1">
    <header>
        @include('elements.navbar')
    </header>

    @yield('app')
</div>

<footer class="footer footer-center bg-base-300 text-base-content p-10 mt-auto">
    <div class="container mx-auto">
        <p class="mb-4">{{ str_replace('{year}', date('Y'), setting('copyright')) }} | @lang('messages.copyright')</p>

        <div class="flex gap-4 justify-center">
            @foreach(social_links() as $link)
                <a href="{{ $link->value }}" 
                   title="{{ $link->title }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-circle"
                   style="background: {{ $link->color }}; border-color: {{ $link->color }}">
                    <i class="{{ $link->icon }} text-white"></i>
                </a>
            @endforeach
        </div>
    </div>
</footer>

@stack('footer-scripts')

</body>
</html>
