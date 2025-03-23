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
            {{-- Pregunta 1. --}}
            @livewire('user-preference-form')
        </div>
    </div>

</x-app-layout>
