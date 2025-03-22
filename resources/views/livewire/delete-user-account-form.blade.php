<div class="mt-4" x-data="{ modal: $wire.entangle('showModal')}">
    <legend class="text-2xl mb-4">{{ $legend }}</legend>
    <p class="mt-4 mb-4">La eliminación de cuenta es permanente sin posibilidad de recuperación.</p>
    <x-button class="bg-warning text-white px-2 py-1" wire:click="unhideModal" id="dangerButton">
        Eliminar cuenta
    </x-button>

    {{-- Modal de confirmación para eliminación de cuenta --}}
    <div id="confirmDeleteForm" x-show="modal" x-transition.duration.200ms>
        <p class="mt-4">Para confirmar la eliminación de su cuenta ingrese su contraseña.</p>
        <form wire:submit="deleteAccount">
            <x-input type="password" wire:model="contraseña" class="w-1/2 mt-4"/>
            @error('contraseña')
                <p class="text-red-500 mt-4 mb-4">{{ $message }}</p>
            @enderror

            <div class="mt-4">
                <x-button type="button" class="bg-secondary text-white px-2 py-1" wire:click="hideModal">
                    Cancelar
                </x-button>
                <x-button type="submit" class="bg-danger text-white px-2 py-1">
                    Confirmar eliminación de cuenta
                </x-button>
            </div>
        </form>
    </div>
</div>
