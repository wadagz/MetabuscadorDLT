<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-application-logo class="app-logo-auth-cards mb-4 mt-4" />
        </x-slot>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <div class="card-header">
            <legend>Inicio de sesión</legend>
        </div>
        <div class="card-body justify-content-center">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-4">
                    <div>
                        <x-label for="email" value="Correo electrónico" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <x-validation-errors class="" />
                </div>

                <div class="row">
                    <x-button class="btn-primary">
                        Iniciar sesión
                    </x-button>
                </div>
            </form>

        </div>
        <div class="flex items-center justify-end mt-4 mb-4">
            @if (Route::has('password.request'))
                <span>¿Olvidaste tu contraseña?</span>
                <a class="btn-link" href="{{ route('password.request') }}">
                    Recuperar contraseña
                </a>
            @endif

            <div>
                <span>¿No tienes cuenta?</span>
                <a class="btn-link" href="{{ route('register') }}">
                    Registro
                </a>
            </div>

        </div>
    </x-authentication-card>
</x-guest-layout>
