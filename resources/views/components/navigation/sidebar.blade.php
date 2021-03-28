<nav class="sidebar">
    <button
        class="btn btn-close d-block mr-auto"
        aria-label="Fechar menu de navegação"
        onclick="document.querySelector('#navigation').checked = false"
    >
    </button>

    <hr/>

    <div class="d-flex flex-row align-items-center">
        <div>
            <span class="text-dark mr-auto">{{ Auth::user()->name }}</span>
            <span class="text-muted mr-auto">{{ Auth::user()->email }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-none border-0 link-primary" type="submit">Sair</button>
        </form>
    </div>

    <hr/>

    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
        <x-navigation.nav-item :active="true" href="/">
            Home
        </x-navigation.nav-item>

        <x-navigation.dropdown label="Relatórios" id="actions">

            <x-navigation.dropdown-item href="{{ url('report/news') }}">
                Notícias
            </x-navigation.dropdown-item>

            <x-navigation.dropdown-item href="{{ url('report/news_chart') }}">
                Notícias (consolidado)
            </x-navigation.dropdown-item>

            <x-navigation.dropdown-item href="{{ url('report/news_tagcloud') }}">
                Notícias (Tag Cloud)
            </x-navigation.dropdown-item>

        </x-navigation.dropdown>

    </ul>
</nav>
