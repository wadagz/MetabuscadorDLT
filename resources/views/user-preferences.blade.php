<x-app-layout>
    <x-slot name="header">
        <h2 class="text-4xl">
            Mis preferencias
        </h2>
    </x-slot>

    <div class="container mx-auto md:grid md:grid-cols-4 md:gap-16">
        <div class="col-start-1">
            <x-profile-dashboard-menu />
        </div>
        <div class="md:col-start-2 md:col-span-3">
            <div class="text-lg mb-4">
                <p>
                    Aquí puedes indicar tus preferencias al buscar hospedaje.
                </p>
                <p>
                    Esto puede ayudarnos a encontrar mejores opciones para tí.
                </p>
            </div>

            <hr class="mb-4">

            @livewire('user-preference-form')
        </div>
    </div>

</x-app-layout>
