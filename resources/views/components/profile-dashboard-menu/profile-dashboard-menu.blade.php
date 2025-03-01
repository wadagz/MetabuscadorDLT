<div class="card py-4 px-4">
    <div class="d-grid gap-4">
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
