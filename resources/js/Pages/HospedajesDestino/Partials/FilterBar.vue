<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
</script>

<template>
    <div class="mt-4 bg-light max-w-xl xl:max-w-7xl mx-auto rounded-md border border-gray-400">
        <div class="flex flex-nowrap items-center justify-evenly">
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Ordenar</label>
                <Icon icon="material-symbols:sort" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option>A a la Z</option>
                    <option>Z a la A</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Precio</label>
                <Icon icon="mdi:cash" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option>Hasta $5000</option>
                    <option>$5000 a $10000</option>
                    <option>$10000 a $20000</option>
                    <option>Mayor a $20000</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Amenidades</label>
                <Icon icon="mdi:home-plus" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option>WiFi Gratuito</option>
                    <option>Aire Acondicionado</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Cant. Personas</label>
                <Icon icon="mdi:account-multiple" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
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
