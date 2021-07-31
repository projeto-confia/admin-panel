<x-layouts.guest>

    <x-slot name="title">Esqueci a senha | CONFIA</x-slot>

    <div class="login-page">

        <div class="login-page__skewed"></div>

        <main class="container-fluid card p-4 mt-4 mx-3 shadow login-page__card">
            <div class="mb-4 text-sm text-gray-600">
                Informe seu e-mail para que seja enviado um link para recuperação de acesso
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="col-12 mb-3">
                    <label for="email" class="form-label">{{ __('Email')  }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus />

                    @error('email')
                    <x-ui.invalid-feedback>{{ $message }}</x-ui.invalid-feedback>
                    @enderror
                </div>
                <div class="d-flex items-center flex-row-reverse justify-end mt-4">
                    <button class="btn btn-primary" type="submit">
                        Enviar
                    </button>
                </div>
            </form>
        </main>

    </div>

</x-layouts.guest>
