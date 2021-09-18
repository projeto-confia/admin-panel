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
        <x-navigation.nav-item class="{{ request()->routeIs('welcome.show') ? 'active' : '' }}"
           href="/"
        >
            Dashboard
        </x-navigation.nav-item>

        <x-navigation.dropdown label="Relatórios" id="actions" class="{{
            collect(['news.index', 'news_chart.index', 'news_tagcloud.index', 'news_actual_detected.index'])
                ->some(fn ($route) => request()->routeIs($route))
                 ? 'show'
                 : ''
            }}">

            <x-navigation.dropdown-item class="{{ request()->routeIs('news.index') ? 'active' : '' }}" href="{{ url('report/news') }}">
                Notícias
            </x-navigation.dropdown-item>

            <x-navigation.dropdown-item class="{{ request()->routeIs('news_chart.index') ? 'active' : '' }}" href="{{ url('report/news_chart') }}">
                Quantitativo
            </x-navigation.dropdown-item>

            <x-navigation.dropdown-item class="{{ request()->routeIs('news_actual_detected.index') ? 'active' : '' }}" href="{{ url('report/news_actual_detected') }}">
                Precisão
            </x-navigation.dropdown-item>

            <x-navigation.dropdown-item class="{{ request()->routeIs('news_tagcloud.index') ? 'active' : '' }}" href="{{ url('report/news_tagcloud') }}">
                Tag Cloud
            </x-navigation.dropdown-item>



        </x-navigation.dropdown>

        <x-navigation.nav-item class="{{ request()->routeIs('curadoria.*') ? 'active' : '' }}"
                               href="/curadoria"
        >
            Curadoria
        </x-navigation.nav-item>

    @can('viewAny', \App\Models\User::class)
        <x-navigation.nav-item
            class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}"
            href="{{ route('usuarios.index') }}"
        >
            Gerenciar usuários
        </x-navigation.nav-item>
        @endcan
    </ul>
</nav>
