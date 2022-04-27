<x-layouts.app>
    <x-slot name="title">Configuração do Automata | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Configuração do Automata</h1>
    </header>
    <main class="p-3">

        @if(! $isUpdated)
        <div class="alert alert-warning" role="alert">
            Algumas configurações ainda não foram aplicadas, caso as altere novamente o valor atual não será aplicado.
        </div>
        @endif

        <div class="d-flex flex-row-reverse mb-2">
            <a class="btn btn-primary" href="{{ route('configuration.create') }}">Adicionar configuração</a>
        </div>

        <ul class="list-group">
            @foreach($envVariables as $envVariable)
            <li class="list-group-item">
                <p class="h5">{{$envVariable->name}} @if(! $envVariable->updated)<span class="badge bg-warning">Não aplicada</span>@endif</p>
                <p>{{$envVariable->description}}</p>
                <p class="mb-0">Valor:</p>
                <textarea readonly class="m-0 w-100 bg-light rounded border-0" rows="1" >{{$envVariable->value}}</textarea>

                <div class="btn-group float-end mt-2" role="group" aria-label="Basic example">
                    <button
                        class="btn btn-outline-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-{{ $envVariable->id  }}-delete"
                    >
                        Apagar
                    </button>
                    <button type="button" class="btn btn-primary">Editar</button>
                </div>
            </li>
            @endforeach
        </ul>

    </main>
    @foreach($envVariables as $envVariable)
    <div class="modal fade" id="modal-{{ $envVariable->id  }}-delete" tabindex="-1" aria-labelledby="modal-delete-{{ $envVariable->id }}-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-delete-{{ $envVariable->id }}-label">Apagar variável de configuração</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Você deseja apagar a variável de configuração
                        <span class="text-black-50">{{ $envVariable->name }}</span>
                        ?
                    </p>
                    <span class="text-danger">Esta ação é irreversível.</span>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('configuration.delete', ['id' => $envVariable->id]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-outline-danger">Apagar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @push('scripts')
        <script defer>
            {{--window.addEventListener('load', function() { CONFIA.pages.user.edit({{ $user->isAdmin() }});});--}}
        </script>
    @endpush

</x-layouts.app>
