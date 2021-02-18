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
        <x-navigation.nav-item :active="true" href="#">
            Home
        </x-navigation.nav-item>

        <x-navigation.nav-item href="#">
            Link
        </x-navigation.nav-item>

        <x-navigation.dropdown label="Dropdown" id="actions">

            <x-navigation.dropdown-item href="#">
                Action
            </x-navigation.dropdown-item>

            <x-navigation.dropdown-item href="#">
                Another action
            </x-navigation.dropdown-item>

            <li><hr class="dropdown-divider"></li>

            <x-navigation.dropdown-item href="#">
                Something else here
            </x-navigation.dropdown-item>

        </x-navigation.dropdown>

    </ul>
</nav>
