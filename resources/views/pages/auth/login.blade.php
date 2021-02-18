<x-layouts.guest>

    <x-slot name="title">Login | CONFIA</x-slot>
    <div class="login-page">

        <div class="login-page__skewed"></div>

        <main class="container-fluid card p-4 mt-4 mx-3 shadow login-page__card">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="col-12 mb-3">
                    <label for="email" class="form-label">{{ __('Email')  }}</label>
                    <input type="email" class="form-control" id="email" name="email" />

                    @error('email')
                    <x-ui.invalid-feedback>{{ $message }}</x-ui.invalid-feedback>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" />

                    @error('password')
                    <x-ui.invalid-feedback>{{ $message }}</x-ui.invalid-feedback>
                    @enderror
                </div>

                <div class="form-check col-12 mb-3">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <div class="col-12 d-flex flex-row-reverse justify-content-between mt-3">
                    <button class="btn btn-primary" type="submit">{{ __('Submit') }}</button>
                </div>

            </form>
        </main>
    </div>

</x-layouts.guest>
