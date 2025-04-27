<script setup>

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
</div>
<div>
    <div v-for="camino in caminos">
        {{ camino }}
    </div>
</div>
</template>
