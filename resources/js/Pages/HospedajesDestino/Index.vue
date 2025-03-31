<script setup>
import { ref } from 'vue';
import SearchBar from '../../Components/SearchBar.vue';
import CardHospedaje from './Partials/CardHospedaje.vue';
import FilterBar from './Partials/FilterBar.vue';
import MapComponent from './Partials/LeafletMapComponent.vue';

const props = defineProps({
    destino: String,
    fechaPartida: String,
    fechaRegreso: String,
    puntoPartida: String,
    hospedajes: {
        type: Array,
        // We assume that the hospedajes array has direccion objects loaded
        // If not, see the note below about loading direccion data
        default: () => []
    },
    nombresDestinos: Array,
});

const selectedHospedajeId = ref(null);

const handleSelectHospedaje = (hospedajeId) => {
    selectedHospedajeId.value = hospedajeId;
};
</script>

<template>
<SearchBar
    :destino="destino"
    :fechaPartida="fechaPartida"
    :fechaRegreso="fechaRegreso"
    :puntoPartida="puntoPartida"
    :nombresDestinos="nombresDestinos"
/>

<div class="container mx-auto mt-4 mb-4">
    <FilterBar />
</div>

<div class="container mx-auto mb-2">
    <h2 class="text-xl">
        Hospedajes encontrados en {{ destino }}
    </h2>
</div>

<div class="container mx-auto grid grid-cols-2 gap-4">
    <!-- Lista de hospedajes -->
    <div class="bg-gray-200 rounded-lg border border-gray-400 shadow-md overflow-y-scroll h-[44rem]">
        <div v-for="hospedaje in hospedajes" :key="hospedaje.id">
            <CardHospedaje 
                :hospedaje="hospedaje" 
                @select-hospedaje="handleSelectHospedaje"
            />
        </div>
    </div>
    <!-- Mapa con ubicaciones de hospedajes -->
    <div class="bg-gray-200 rounded-lg border border-gray-400 shadow-md h-[44rem]">
        <MapComponent 
            :hospedajes="hospedajes" 
            :selectedHospedajeId="selectedHospedajeId"
        />
    </div>
</div>
</template>