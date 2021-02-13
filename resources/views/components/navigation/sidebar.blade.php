<nav class="sidebar">
    <button
        class="btn btn-close float-end"
        aria-label="Fechar menu de navegação"
        onclick="document.querySelector('#navigation').checked = false"
    >
    </button>

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
