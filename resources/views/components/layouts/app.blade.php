@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'CONFIA') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

</head>
<body>
    <nav class="navbar navbar-light bg-light shadow">
        <div class="container-fluid overflow-hidden">
            <a href="/" class="d-flex align-items-center pe-5 text-decoration-none text-dark">
                <x-common.logo class="py-0 mx-1" />
                <span class="h4">CONFIA</span>
            </a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-row ">
                <x-navigation.nav-item :active="true" href="/">
                    Home
                </x-navigation.nav-item>

                <x-navigation.dropdown label="Relatórios" id="actions">

                    <x-navigation.dropdown-item href="{{ url('report/news') }}">
                        Notícias
                    </x-navigation.dropdown-item>

                    <x-navigation.dropdown-item href="{{ url('report/news_chart') }}">
                        Notícias (Consolidado)
                    </x-navigation.dropdown-item>

                    <x-navigation.dropdown-item href="{{ url('report/news_tagcloud') }}">
                        Notícias (Tag Cloud)
                    </x-navigation.dropdown-item>

                    <x-navigation.dropdown-item href="{{ url('report/news_actual_detected') }}">
                        Notícias (Precisão)
                    </x-navigation.dropdown-item>

                </x-navigation.dropdown>
            </ul>

            <label for="navigation" class="btn btn-light" tabindex="0" role="button" aria-label="Abre e fecha menu de usuário.">
                <x-icons.menu width="30"/>
            </label>

            <input class="visually-hidden menu-sidebar" id="navigation" type="checkbox">

            <x-navigation.sidebar />
        </div>
    </nav>

    <div class='container'>
        {{ $slot }}
    </div>

@stack('scripts')
</body>
</html>
