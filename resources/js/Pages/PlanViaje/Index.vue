<script setup>
import Camino from './Partials/Camino.vue';

const props = defineProps({
    destino: Object,
    fechaPartida: String,
    fechaRegreso: String,
    puntoPartida: String,
    caminos: Object,
})
</script>

<template>
<div class="card container mx-auto pt-4 pb-10">
    <h1 class="text-3xl mb-4">Planificación de Viaje</h1>
    <div v-if="caminos">
        <h2 class="text-xl">
            Seleccione el camino de rutas que desee tomar para llegar al destino.
        </h2>
        <h2 class="text-lg">
            {{ puntoPartida }} - {{ destino.nombre }}
        </h2>
        <div
            v-for="camino in caminos"
            class="my-4 p-2 "
        >
            <Camino :camino="camino" />

            <hr class="border border-gray-200 mt-8">
        </div>
    </div>

    <div v-else class="flex justify-center">
        <h2 class="text-2xl">
            Ocurrió un problema al obtener las rutas de viaje.
        </h2>
    </div>
</div>
</template>
