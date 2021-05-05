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
    <nav class="navbar navbar-light nav-bar bg-light shadow">
        <div class="container-fluid">
            <a href="/" class="d-flex align-items-center pe-5 text-decoration-none text-dark">
                <x-common.logo class="py-0 mx-1" />
                <span class="h4">CONFIA</span>
            </a>

            <a id="sidebar-btn" class="btn btn-light sidebar-btn" tabindex="0" role="button" aria-label="Abre e fecha menu de usuário.">
                <x-icons.menu width="30"/>
            </a>


        </div>
    </nav>
    <div class="d-flex flex-row">
        <x-navigation.sidebar id="sidebar" />

        <div class='container content'>
            {{ $slot }}
        </div>
    </div>


@stack('scripts')

{{-- @todo(CarlosHMoreira): setup js boilerplate --}}
<script async defer>
    var sidebarBtn = document.querySelector('#sidebar-btn');
    var sidebar = document.querySelector('#sidebar');
    var body = document.querySelector('body');

    if (sidebarBtn && sidebar && body) {
        sidebarBtn.addEventListener('click', function () {
            body.classList.toggle('body-overflow-on-sidebar-opened');
            sidebar.classList.toggle('opened');
        });
    }

</script>
</body>
</html>
