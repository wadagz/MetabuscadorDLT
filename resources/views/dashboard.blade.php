<x-app-layout>
    <x-slot name="header">
        <h1>
            Mi perfil
        </h1>
    </x-slot>

    <!-- Posicionamiento no responsivo en dimensiones pequeñas de navegador -->
    <div class="container">
        <div class="row column-gap-5">
            <div class="col-2">
                <x-profile-dashboard-menu />
            </div>
            <div class="col-8">
                <!-- Actualizar información del perfil -->
                <livewire:update-user-info-form
                    legend="Cambiar información de perfil"
                    action="{{ route('user-profile-information.update') }}"
                    method='POST'
                    atMethod='PUT'
                    btnText="Actualizar información"
                    nombre="{{ Auth::user()->name }}"
                    correo="{{ Auth::user()->email }}"
                />

                <hr>

                <!-- Actualizar contraseña -->
                <livewire:update-password
                    legend="Cambiar contraseña"
                />

                <hr>

                <!-- Eliminar cuenta -->
                <livewire:delete-user-account-form
                    legend="Eliminar cuenta"
                />

            </div>
        </div>
    </div>

</x-app-layout>
