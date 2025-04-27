<script setup>

const props = defineProps({
    destino: String,
    fechaPartida: Number,
    fechaRegreso: Number,
    puntoPartida: String,
})
</script>

<template>
    {{ destino }}
    {{ fechaPartida }}
    {{ fechaRegreso }}
    {{ puntoPartida }}
<div class="card container mx-auto pt-4 pb-10">
    <h1 class="text-3xl mb-4">Planificación de Viaje</h1>
</div>
</template>
