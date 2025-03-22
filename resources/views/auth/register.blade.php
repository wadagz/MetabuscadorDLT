<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('images/logotipo.png') }}" class="max-w-60"/>
        </x-slot>

        <div class="border-b border-gray-200">
            <legend class="text-2xl text-center my-2">Registro</legend>
        </div>

        <div class="mt-4 flex justify-center items-center">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4 space-y-4">
                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
                    </div>

                    <div >
                        <x-label for="correo" value="Correo electrónico" />
                        <x-input id="correo" class="mt-1 w-full" type="email" name="correo" :value="old('correo')" required autocomplete="username" />
                    </div>

                    <div >
                        <x-label for="contraseña" value="Contraseña" />
                        <x-input id="contraseña" class="mt-1 w-full" type="password" name="contraseña" required autocomplete="new-password" />
                    </div>

                    <div >
                        <x-label for="contraseña_confirmation" value="Confirmación de contraseña" />
                        <x-input id="contraseña_confirmation" class="mt-1 w-full" type="password" name="contraseña_confirmation" required autocomplete="new-password" />
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

                    <x-validation-errors class="" />

                    <div class="flex justify-center mt-4">
                        <x-button class="bg-primary-500 text-white p-2 transition duration-300 hover:bg-[#1c3e7c]">
                            Registrarme
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex-col items-center justify-end mt-4 mb-4 mx-8">
            <div>
                <span>¿Ya tienes una cuenta?</span>
                <a class="text-blue-600 transition duration-300 text-blue-800" href="{{ route('login') }}">
                    Inicia sesión
                </a>
            </div>

        </div>
    </x-authentication-card>
</x-guest-layout>
