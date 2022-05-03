<x-layouts.app>
    <x-slot name="title">Editar configuração | CONFIA</x-slot>
    <header class="my-3">
        <h1 class="text-dark">Editar configuração de ambiente</h1>
    </header>
    <main>
        <div class="card mb-3 p-4">
            <form class="row g-3" action="{{route('configuration.update', ['env_variable' => $envVariable])}}" method="POST" novalidate>
                @method('PUT')
                @csrf
                <div class="col-12">
                    <p>{{ $envVariable->name }}</p>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="Digite a descrição da configuração de ambiente"
                            value="{{ old('description', $envVariable->description) }}"
                        >
                        <label for="description">Descrição</label>
                    </div>
                    @error('description')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div id="types-outlet">
                    {{  $envVariableComponent->render() }}
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
            // window.addEventListener('load', function() { CONFIA.pages.configuration.create(); });
        </script>
    @endpush
</x-layouts.app>
