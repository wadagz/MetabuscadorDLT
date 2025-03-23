<x-app-layout>
    <x-slot name="header">
        <h1 class="text-4xl">
            Mi perfil
        </h1>
    </x-slot>

    <!-- Posicionamiento no responsivo en dimensiones pequeñas de navegador -->
    <div class="container mx-auto md:grid md:grid-cols-4 md:gap-16">
        <div class="md:col-start-1">
            <x-profile-dashboard-menu />
        </div>
        <div class="md:col-start-2 md:col-span-3">
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

</x-app-layout>
