<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';

// Será necesario cambiar los props para cuando tengamos definidos los hospedajes y la forma de buscarlos.
const props = defineProps({
    destino: String | null,
    fechaPartida: String | null,
    fechaRegreso: String | null,
    puntoPartida: String | null,
})
</script>

<template>
<div class="mt-4 bg-light max-w-xl xl:max-w-7xl mx-auto rounded-md border border-gray-200">
    <form :action="route('searchHospedaje')" method="GET">
        <div class="flex flex-nowrap items-center justify-evenly">
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Destino o lugar turístico</label>
                <Icon icon="material-symbols:search" />
                <input name="destino" type="text" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Fecha de partida</label>
                <Icon icon="mdi:calendar-month-outline" />
                <input name="fechaPartida" type="date" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3">
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Fecha de regreso</label>
                <Icon icon="mdi:calendar-month-outline" />
                <input name="fechaRegreso" type="date" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" >
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Punto de partida</label>
                <Icon icon="mdi:location" />
                <input name="puntoPartida" type="text" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Guadalajara">
            </div>
            <div class="flex-grow text-center">
                <button type="submit" class="rounded-md bg-primary-500 w-11/12 py-1 mr-2 mt-6 text-white transition duration-300 hover:bg-primary-400">Buscar</button>
            </div>
        </div>
    </form>
</div>
</template>
