<nav {{ $attributes }} class="sidebar px-3">
    <div class="d-flex flex-row align-items-center">
        <div>
            <span class="text-dark mr-auto">{{ Auth::user()->name }}</span>
            <span class="text-muted mr-auto">{{ Auth::user()->email }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="bg-none border-0 link-primary ml-auto d-block" type="submit">Sair</button>
    </form>

    <hr/>

    <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex ">
        <x-navigation.nav-item :active="true" href="/">
            Dashboard
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
</nav>
