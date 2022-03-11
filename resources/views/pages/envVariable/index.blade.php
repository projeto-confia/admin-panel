<x-layouts.app>
    <x-slot name="title">Configuração do Automata | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Configuração do Automata</h1>
    </header>
    <main class="p-3">
        <div class="d-flex flex-row-reverse mb-2">
            <a class="btn btn-primary" href="{{ route('usuarios.create') }}">Adicionar Usuário</a>
        </div>
{{--            <form class="row g-3" action="{{route('configuration.update', $user->id)}}" method="POST" novalidate>--}}
        <form class="row g-3" action="/" method="POST" novalidate>
            @csrf
            @method('PUT')

            <ul class="list-group">
                @foreach($envVariables as $envVariable)
                <li class="list-group-item">
                    <p class="h5">{{$envVariable->name}}</p>
                    <p>{{$envVariable->description}}</p>
                    <p class="mb-0">Valor:</p>
                    <textarea readonly class="m-0 w-100 bg-light rounded border-0" rows="1" >{{$envVariable->value}}</textarea>

                    <div class="btn-group float-end mt-2" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-danger">Apagar</button>
                        <button type="button" class="btn btn-primary">Editar</button>
                    </div>
                </li>
                @endforeach
            </ul>

        </form>
    </main>

    @push('scripts')
        <script defer>
            {{--window.addEventListener('load', function() { CONFIA.pages.user.edit({{ $user->isAdmin() }});});--}}
        </script>
    @endpush

</x-layouts.app>
