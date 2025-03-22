<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('images/logotipo.png') }}" class="max-w-60"/>
        </x-slot>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <div class="border-b border-gray-200">
            <legend class="text-2xl text-center my-2">Inicio de sesión</legend>
        </div>
        <div class="mt-4 flex justify-center items-center">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4 space-y-4">
                    <div>
                        <x-label for="email" value="Correo electrónico" />
                        <x-input id="email" class="mt-1 min-w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="mt-1 min-w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <x-validation-errors />
                </div>

                <div class="mt-4 flex justify-center">
                    <x-button class="bg-primary-500 text-white p-2 transition duration-300 hover:bg-[#1c3e7c]">
                        Iniciar sesión
                    </x-button>
                </div>
            </form>

        </div>
        <div class="flex-col items-center justify-end mt-4 mb-4 mx-8">
            @if (Route::has('password.request'))
                <span>¿Olvidaste tu contraseña?</span>
                <a class="text-blue-600 transition duration-300 text-blue-800" href="{{ route('password.request') }}">
                    Recuperar contraseña
                </a>
            @endif

            <div>
                <span>¿No tienes cuenta?</span>
                <a class="text-blue-600 transition duration-300 text-blue-800" href="{{ route('register') }}">
                    Registro
                </a>
            </div>

        </div>
    </x-authentication-card>
</x-guest-layout>
