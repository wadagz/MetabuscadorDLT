<div class="py-4 px-4 bg-light rounded-md border border-gray-200 shadow-sm">
    <div class="grid grid-rows-3 gap-4">
        <x-profile-dashboard-menu.anchor href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            Mi perfil
        </x-profile-dashboard-menu.anchor>
        <x-profile-dashboard-menu.anchor href="{{ route('user-preferences') }}" :active="request()->routeIs('user-preferences')">
            Mis preferencias
        </x-profile-dashboard-menu.anchor>
        <x-profile-dashboard-menu.anchor href="{{ route('customer-help') }}" :active="request()->routeIs('customer-help')">
            Ayuda
        </x-profile-dashboard-menu.anchor>
    </div>
</div>
