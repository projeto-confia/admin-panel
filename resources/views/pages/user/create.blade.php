<x-layouts.app>
    <x-slot name="title">Criar usuário | CONFIA</x-slot>

    <header class="my-3">
        <h1 class="text-dark">Criar usuário</h1>
    </header>
    <main>
        {{--    tabela    --}}
        <div class="card mb-3 p-4">
            <form class="row g-3" action="{{route('usuarios.store')}}" method="POST" novalidate>
                @csrf
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

                <div class="col-12">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="E-mail"
                            value="{{ old('email') }}"
                        >
                        <label for="email">E-mail</label>
                    </div>
                    @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="cpf"
                            name="cpf"
                            placeholder="CPF"
                            value="{{ old('cpf') }}"
                            size="11"
                        >
                        <label for="cpf">CPF</label>
                    </div>
                    @error('cpf')
                    <span class="text-danger small">{{ $message }}</span>
                    @enderror()
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input
                            id="is_admin"
                            name="is_admin"
                            class="form-check-input"
                            type="checkbox"
                            value="{{ old('is_admin', true) }}"
                            {{old('is_admin') ? 'checked' : ''}}
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

                <div class="d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary">
                        Criar usuário
                    </button>
                </div>

            </form>
        </div>
    </main>
    @push('scripts')
        <script defer>
            window.addEventListener('load', function() { CONFIA.pages.user.create();});
        </script>
    @endpush
</x-layouts.app>
