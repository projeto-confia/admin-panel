@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ??  config('app.name', 'CONFIA') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

</head>
<body>
    <nav class="navbar navbar-light bg-light shadow">
        <div class="container-fluid overflow-hidden">
            <a href="/" class="d-flex align-items-center px-3 text-decoration-none text-dark">
                <x-common.logo class="py-0 mx-1" />
                <span class="h4">CONFIA</span>
            </a>

            <label for="navigation" class="btn btn-light" tabindex="0" role="button" aria-label="Abre e fecha menu de navegação">
                <x-icons.menu width="30"/>
            </label>
            <input class="visually-hidden menu-sidebar" id="navigation" type="checkbox">

            <x-navigation.sidebar />
        </div>
    </nav>

    <div>
        {{ $slot }}
    </div>

@stack('scripts')
</body>
</html>
