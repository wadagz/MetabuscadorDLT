<x-profile-dashboard-menu.form
    legend="{{ $legend }}"
    action="{{ $action }}"
    method="{{ $method }}"
    atMethod="{{ $atMethod }}"
    btnText="{{ $btnText }}"
>
    <x-profile-dashboard-menu.input-control
        name="nombre"
        id="nombre"
        type="text"
        placeholder="Ej. Antonio Ramírez"
        label="Nombre"
        wire:model.live.debounce.500ms="nombre"
    />
    <x-profile-dashboard-menu.input-control
        name="correo"
        id="correo"
        type="email"
        label="Correo"
        wire:model.live.debounce.500ms="correo"
    />
</x-profile-dashboard-menu>
