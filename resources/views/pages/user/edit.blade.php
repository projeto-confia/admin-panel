<x-layouts.app>
    <x-slot name="title">Criar usuário | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Criar usuário</h1>
    </header>
    <main>
        {{--    tabela    --}}
        <div class="card mb-3 p-4">
            <form class="row g-3" action="{{route('usuarios.update', $user->id)}}" method="POST" novalidate>
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
                            value="{{ old('name', $user->name) }}"
                        >
                        <label for="name">Nome</label>
                    </div>
                    @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="col-12">
                    <p>{{ $user->email }}</p>
                </div>

                @if(auth()->user()->id !== $user->id)
                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is_admin"
                            name="is_admin"
                            class="form-check-input"
                            type="checkbox"
                            value="{{ true }}"
                            {{old('is_admin', $user->is_admin) ? 'checked' : ''}}
                        >
                        <label class="form-check-label" for="is_admin">
                            Deve ser administrador do sistema ?
                        </label>
                    </div>

                    @error('is_admin')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div id="is_admin_alert" aria-disabled="false" class="alert alert-warning d-none" role="alert">
                    Ao marcar, este usuário terá as permissões de acessar relatórios restritos além de poder criar outros usuários.
                </div>
                @endif

                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary">
                        Atualizar usuário
                    </button>
                </div>

            </form>
        </div>
    </main>
    @if(auth()->user()->id !== $user->id)
        @push('scripts')
            <script defer>
                window.addEventListener('load', function() { CONFIA.pages.user.edit({{ $user->isAdmin() }});});
            </script>
        @endpush
    @endif
</x-layouts.app>
