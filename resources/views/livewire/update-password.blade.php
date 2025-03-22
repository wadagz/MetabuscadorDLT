<div class="mt-4">
    <form action="{{ route('user-password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <fieldset>
            <legend class="text-2xl mb-4">{{ $legend }}</legend>
            <div class="row mb-5">
                <x-profile-dashboard-menu.input-control
                    name="contraseña_actual"
                    id="contraseña_actual"
                    type="password"
                    placeholder="Contraseña actual"
                    label="Contraseña actual"
                    wire:model.live.debounce.500ms="contraseña_actual"
                />
                <x-profile-dashboard-menu.input-control
                    name="contraseña"
                    id="contraseña"
                    type="password"
                    placeholder="Contraseña nueva"
                    label="Contraseña nueva"
                    wire:model.live.debounce.500ms="contraseña"
                />
                <x-profile-dashboard-menu.input-control
                    name="contraseña_confirmation"
                    id="contraseña_confirmation"
                    type="password"
                    placeholder="Confirmar contraseña"
                    label="Confirmar contraseña"
                    wire:model.live.debounce.500ms="contraseña_confirmation"
                />
            </div>
            <x-button class="bg-primary-300 text-white px-2 py-1 mb-4">Actualizar contraseña</x-button>
        </fieldset>
    </form>
</div>
