<nav class="sidebar px-3" style="min-height: 20%;">
    <hr/>

    <div class="d-flex flex-row align-items-center">
        <div>
            <span class="text-dark mr-auto">{{ Auth::user()->name }}</span>
            <span class="text-muted mr-auto">{{ Auth::user()->email }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="bg-none border-0 p-0 mt-2 link-primary" type="submit">Sair</button>
    </form>
    
    <hr/>
</nav>
