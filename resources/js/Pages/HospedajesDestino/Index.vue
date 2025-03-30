<script setup>
import SearchBar from '../../Components/SearchBar.vue';
import CardHospedaje from './Partials/CardHospedaje.vue';

const props = defineProps({
    destino: String,
    fechaPartida: String,
    fechaRegreso: String,
    puntoPartida: String,
    hospedajes: Array,
});

</script>

<template>
<SearchBar
    :destino="destino"
    :fechaPartida="fechaPartida"
    :fechaRegreso="fechaRegreso"
    :puntoPartida="puntoPartida"
/>
<div>Aquí van los filtros para buscar hospedajes.</div>

<div class="container mx-auto grid grid-cols-2 gap-4 h-1/2">
    <!-- Lista de hospedajes -->
    <div class="bg-gray-200 rounded-lg overflow-y-scroll h-1/6">
        <div v-for="hospedaje in hospedajes" :key="hospedaje.id">
            <CardHospedaje :hospedaje="hospedaje" />
        </div>
    </div>
    <div class="bg-gray-200 rounded-lg h-1/6">A la derecha un mapa donde se muestren las ubicaciones de los hospedajes.</div>
</div>


</template>
