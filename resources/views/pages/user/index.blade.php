<x-layouts.app>
    <x-slot name="title">Usuários | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Usuários</h1>
    </header>
    <main>
        {{--    tabela    --}}
        <div class="card mb-3 p-4">
            <div class="d-flex flex-row-reverse">
                <a class="btn btn-primary" href="{{ route('usuarios.create') }}">Adicionar Usuário</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">É administrador ?</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Sim' : 'Não' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </main>

</x-layouts.app>
