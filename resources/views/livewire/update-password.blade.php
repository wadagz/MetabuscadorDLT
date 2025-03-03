<div class="bs-component">
    <form action="{{ route('user-password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <fieldset>
            <legend>{{ $legend }}</legend>
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
            <x-button class="btn-primary">Actualizar contraseña</x-button>
        </fieldset>
    </form>
</div>
