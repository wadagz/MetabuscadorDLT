<script setup>
import Ruta from './Ruta.vue';
const props = defineProps({
    itinerario: Object,
})
</script>

<template>
    <Ruta :ruta="props.itinerario.ruta_transporte" />
</template>
