<x-layouts.guest>

    <x-slot name="title">Criar senha | CONFIA</x-slot>
    <div class="login-page">

        <div class="login-page__skewed"></div>

        <main class="container-fluid card p-4 mt-4 mx-3 shadow login-page__card">
            <form
                method="POST"
                action="{{ route('user.store-password',$request->merge(['id' => $request->id, 'hash' => $request->hash])->all()) }}"
                novalidate
            >
                @csrf

                <div class="col-12 mb-3">
                    <p>Olá, {{ $user->name  }}, preecha os campos abaixo para criar sua senha de acesso  </p>
                </div>

                <div class="col-12 mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" />

                    @error('password')
                    <x-ui.invalid-feedback>{{ $message }}</x-ui.invalid-feedback>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="password_confirmation" class="form-label">Confirmação da senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />

                    @error('password_confirmation')
                    <x-ui.invalid-feedback>{{ $message }}</x-ui.invalid-feedback>
                    @enderror
                </div>

                <div class="col-12 d-flex flex-row-reverse justify-content-between mt-3">
                    <button class="btn btn-primary" type="submit">{{ __('Submit') }}</button>
                </div>

            </form>
        </main>
    </div>

</x-layouts.guest>
