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
                <x-profile-dashboard-menu.form
                    legend="Cambiar información de perfil"
                    action="{{ route('user-profile-information.update') }}"
                    method='POST'
                    atMethod='PUT'
                    btnText="Actualizar información"
                >
                    <x-profile-dashboard-menu.input-control
                        name="nombre"
                        id="nombre"
                        type="text"
                        placeholder="Ej. Antonio Ramírez"
                        value="{{ Auth::user()->name }}"
                        label="Nombre"
                        errorBag="updateProfileInformation"
                    />
                    <x-profile-dashboard-menu.input-control
                        name="correo"
                        id="correo"
                        type="email"
                        value="{{ Auth::user()->email }}"
                        label="Correo"
                        errorBag="updateProfileInformation"
                    />
                </x-profile-dashboard-menu.form>

                <hr>

                <x-profile-dashboard-menu.form
                    legend="Cambiar contraseña"
                    action="{{ route('user-password.update') }}"
                    method='POST'
                    atMethod='PUT'
                    btnText="Actualizar contraseña"
                >
                    <x-profile-dashboard-menu.input-control
                        name="contraseña_actual"
                        id="contraseña_actual"
                        type="password"
                        placeholder="Contraseña actual"
                        label="Contraseña actual"
                        errorBag="updatePassword"
                    />
                    <x-profile-dashboard-menu.input-control
                        name="contraseña"
                        id="contraseña"
                        type="password"
                        placeholder="Contraseña nueva"
                        label="Contraseña nueva"
                        errorBag="updatePassword"
                    />
                    <x-profile-dashboard-menu.input-control
                        name="contraseña_confirmation"
                        id="contraseña_confirmation"
                        type="password"
                        placeholder="Confirmar contraseña"
                        label="Confirmar contraseña"
                        errorBag="updatePassword"
                    />
                </x-profile-dashboard-menu.form>

                <hr>

                <livewire:delete-user-account-form
                    legend="Eliminar cuenta"
                />

            </div>
        </div>
    </div>

</x-app-layout>
