<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-application-logo class="app-logo-auth-cards mb-4 mt-4" />
        </x-slot>

        <div class="card-header">
            <legend>Registro</legend>
        </div>

        <div class="card-body justify-content-center">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-label for="nombre" value="Nombre" />
                    <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                </div>

                <div >
                    <x-label for="correo" value="Correo electrónico" />
                    <x-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required autocomplete="username" />
                </div>

                <div >
                    <x-label for="contraseña" value="Contraseña" />
                    <x-input id="contraseña" class="block mt-1 w-full" type="password" name="contraseña" required autocomplete="new-password" />
                </div>

                <div >
                    <x-label for="contraseña_confirmation" value="Confirmación de contraseña" />
                    <x-input id="contraseña_confirmation" class="block mt-1 w-full" type="password" name="contraseña_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <x-validation-errors class="mb-4" />

                <div class="row mt-4">
                    <x-button class="btn-primary">
                        Registrarme
                    </x-button>
                </div>

            </form>
        </div>
        <div class="flex items-center justify-end mt-4 mb-4">
            <div>
                <span>¿Ya tienes una cuenta?</span>
                <a class="btn-link" href="{{ route('login') }}">
                    Inicia sesión
                </a>
            </div>

        </div>
    </x-authentication-card>
</x-guest-layout>
