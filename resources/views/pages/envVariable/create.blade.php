<x-layouts.app>
    <x-slot name="title">Criar configuração | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Criar configuração de ambiente</h1>
    </header>
    <main>
        <div class="card mb-3 p-4">
            <form class="row g-3" action="{{route('configuration.store')}}" method="POST" novalidate>
                @csrf
                <div class="col-12">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Digite o nome da configuração de ambiente"
                            value="{{ old('name') }}"
                        >
                        <label for="name">Nome</label>
                    </div>
                    @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            placeholder="Digite a descrição da configuração de ambiente"
                            value="{{ old('description') }}"
                        >
                        <label for="description">Descrição</label>
                    </div>
                    @error('description')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select class="form-control" id="type" name="type">
                            <option value>Selecione</option>
                            @foreach($typesAvailable as $typeAvailable => $label)
                                <option value="{{$typeAvailable}}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="types-outlet">

                </div>

                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary">
                        Salvar
                    </button>
                </div>

            </form>
        </div>
    </main>
    <div id="types-templates" >
        @foreach($typesTemplate as $template)
            {{  $template->render() }}
        @endforeach
    </div>
    @push('scripts')
        <script defer>

            window.addEventListener('load', function() { CONFIA.pages.configuration.create();});
        </script>
    @endpush
</x-layouts.app>
