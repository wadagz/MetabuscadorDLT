<div class="bs-component">
    <legend>{{ $legend }}</legend>
    <p class="mt-4">La eliminación de cuenta es permanente sin posibilidad de recuperación.</p>
    <x-button class="btn-warning" wire:click="unhideModal" id="dangerButton">
        Eliminar cuenta
    </x-button>
    <div id="confirmDeleteForm" wire:show="showModal" x-transition.duration.200ms>
        <p class="mt-4">Para confirmar la eliminación de su cuenta ingrese su contraseña.</p>
        <form wire:submit="deleteAccount">
            <x-input type="password" wire:model.live.debounce.500ms="contraseña"/>
            @error('contraseña')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror

            <div class="mt-4">
                <x-button type="button" class="btn-secondary" wire:click="hideModal">
                    Cancelar
                </x-button>
                <x-button type="submit" class="btn-danger">
                    Confirmar eliminación de cuenta
                </x-button>
            </div>
        </form>
    </div>
</div>
