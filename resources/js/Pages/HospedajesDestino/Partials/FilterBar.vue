<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
</script>

<template>
    <div class="bg-light rounded-md border border-gray-400">
        <div class="flex flex-nowrap items-center justify-evenly">
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Ordenar</label>
                <Icon icon="material-symbols:search" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option>Prueba</option>
                    <option>Prueba 2</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Precio</label>
                <Icon icon="mdi:calendar-month-outline" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option>Prueba</option>
                    <option>Prueba 2</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Amenidades</label>
                <Icon icon="mdi:calendar-month-outline" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option>Prueba</option>
                    <option>Prueba 2</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Cant. Personas</label>
                <Icon icon="mdi:location" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option>Prueba</option>
                    <option>Prueba 2</option>
                </select>
            </div>
            <div class="flex-grow text-center">
                <button type="submit" class="rounded-md bg-primary-500 w-11/12 py-1 mr-2 mt-6 text-white transition duration-300 hover:bg-primary-400">
                    Filtrar
                </button>
            </div>
        </div>
    </div>
</template>
