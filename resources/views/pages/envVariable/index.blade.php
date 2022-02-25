<x-layouts.app>
    <x-slot name="title">Configuração do Automata | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Configuração do Automata</h1>
    </header>
    <main>
        {{--    tabela    --}}
        <div class="card mb-3 p-4">
{{--            <form class="row g-3" action="{{route('configuration.update', $user->id)}}" method="POST" novalidate>--}}
            <form class="row g-3" action="/" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="col-12">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Digite o nome do usuário"
                            value="{{ old('name') }}"
                        >
                        <label for="name">Nome</label>
                    </div>
                    @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary">
                        Salvar
                    </button>
                </div>

            </form>
        </div>
    </main>

    @push('scripts')
        <script defer>
            {{--window.addEventListener('load', function() { CONFIA.pages.user.edit({{ $user->isAdmin() }});});--}}
        </script>
    @endpush

</x-layouts.app>
