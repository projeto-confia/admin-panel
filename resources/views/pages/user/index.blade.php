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
                        <th scope="col">Perfil</th>
                        <th scope="col">Senha criada</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Administrador' : 'Comum' }}</td>
                            <td>{{ is_null($user->password) ? 'Não' : 'Sim' }}</td>
                            <td>
                                <ul class="list-group list-group-horizontal">
                                    @if (auth()->user()->id !== $user->id)
                                        @if (! $user->is_blocked)
                                        <li class="list-group-item border-0 bg-transparent">
                                            <button class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal-{{ $user->id  }}-block">
                                                Bloquear
                                            </button>
                                        </li>
                                        @else
                                            <li class="list-group-item border-0 bg-transparent">
                                                <button class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal-{{ $user->id  }}-unblock">
                                                    Desbloquear
                                                </button>
                                            </li>
                                        @endif

                                    <li class="list-group-item border-0 bg-transparent">
                                        <button class="btn btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-{{ $user->id  }}-delete"
                                        >
                                            Apagar
                                        </button>
                                    </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>

        @foreach($users as $user)
            @if (auth()->user()->id !== $user->id)
                @if (! $user->is_blocked)
                {{--Modal Bloquear--}}
                <div class="modal fade" id="modal-{{ $user->id  }}-block" tabindex="-1" aria-labelledby="modal-block-{{ $user->id }}-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-block-{{ $user->id }}-label">Bloquear usuário</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Você deseja bloquear o usuário
                                    <span class="text-black-50">{{ $user->name }}</span>
                                    que possui o e-mail
                                    <span class="text-black-50">{{ $user->email }}</span> ?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('usuarios.block', ['user' => $user->id]) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-outline-danger">Bloquear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{--Modal Bloquear--}}
                <div class="modal fade" id="modal-{{ $user->id  }}-unblock" tabindex="-1" aria-labelledby="modal-unblock-{{ $user->id }}-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-unblock-{{ $user->id }}-label">Desbloquear usuário</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    Você deseja bloquear o usuário
                                    <span class="text-black-50">{{ $user->name }}</span>
                                    que possui o e-mail
                                    <span class="text-black-50">{{ $user->email }}</span> ?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('usuarios.unblock', ['user' => $user->id]) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Desbloquear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


            {{--Modal Apagar--}}
            <div class="modal fade" id="modal-{{ $user->id  }}-delete" tabindex="-1" aria-labelledby="modal-delete-{{ $user->id }}-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-delete-{{ $user->id }}-label">Apagar usuário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Você deseja apagar o usuáriow
                                <span class="text-black-50">{{ $user->name }}</span>
                                que possui o e-mail
                                <span class="text-black-50">{{ $user->email }}</span> ?
                                <br />
                                <br />
                                <span class="text-danger">Esta ação é irreversível.</span>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('usuarios.destroy', ['user' => $user->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-outline-danger">Apagar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach

    </main>

</x-layouts.app>
