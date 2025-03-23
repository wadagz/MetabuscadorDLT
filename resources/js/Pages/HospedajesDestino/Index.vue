<script setup>
import SearchBar from '../../Components/SearchBar.vue';

const props = defineProps({
    destino: String,
    fechaPartida: String,
    fechaRegreso: String,
    puntoPartida: String,
});

</script>

<template>
<SearchBar/>
<p>Hola. Aquí se mostraria a la izquierda los hospedajes disponibles en el destino, y a la derecha un mapa con los hospedajes indicados.</p>
</template>
