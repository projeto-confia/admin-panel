<x-layouts.guest>

    <x-slot name="title">Recuperar senha | CONFIA</x-slot>

    <div class="login-page">

        <div class="login-page__skewed"></div>

        <main class="container-fluid card p-4 mt-4 mx-3 shadow login-page__card">
            <div class="mb-4 text-sm text-gray-600">
                Insira sua nova senha.
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <input type="hidden" name="email" value="{{ $request->email }}">

                <div class="col-12 mb-3">
                    <label for="password" class="form-label">{{ __('Password')  }}</label>
                    <input type="password" class="form-control" id="password" name="password" required autofocus />

                    @error('password')
                    <x-ui.invalid-feedback>{{ $message }}</x-ui.invalid-feedback>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="password_confirmation" class="form-label">Confirmação da senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"/>

                    @error('password_confirmation')
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
