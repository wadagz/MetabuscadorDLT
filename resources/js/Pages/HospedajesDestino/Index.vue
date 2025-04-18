<script setup>
import { onMounted, provide, ref } from 'vue';
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
    amenidades: Array,
    isLoggedIn: Boolean,
    destinoId: Number,
});

const hosps = ref(null);

onMounted(() => {
    hosps.value = props.hospedajes;
})

// Pass the isLoggedIn to child components, like the CardHospedaje component.
provide('isLoggedIn', props.isLoggedIn);

const selectedHospedajeId = ref(null);

const handleSelectHospedaje = (hospedajeId) => {
    selectedHospedajeId.value = hospedajeId;
};

const handleOnFilterChange = ({ filters, sort }) => {
    console.log(hosps.value)
    refetchHospedajes({ filters, sort });
};

async function refetchHospedajes ({ filters, sort }) {
    const params = {
        filters: {
            ...filters,
            destino_id: {
                $eq: props.destinoId,
            },
        },
    };

    if (sort) {
        params.sort = sort.field + ':' + sort.direction;
    }

    // console.log(filters)
    // console.log(sort)
    // console.log(params);

    try {
        const response = await axios.get('/api/hospedajes', { params });
        console.log(response.data);
        hosps.value = response.data;
    } catch(error) {
        console.log(error)
        console.log('Ocurrió un error.')
    }
}
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
    <FilterBar
        @filterChange="handleOnFilterChange"
        :amenidades
    />
</div>

<div class="container mx-auto mb-2">
    <h2 class="text-xl">
        Hospedajes encontrados en {{ destino }}
    </h2>
</div>

<div class="container mx-auto grid grid-cols-2 gap-4">
    <!-- Lista de hospedajes -->
    <div class="bg-gray-200 rounded-lg border border-gray-400 shadow-md overflow-y-scroll h-[44rem]">
        <div v-for="hospedaje in hosps" :key="hospedaje.id">
            <CardHospedaje
                :hospedaje="hospedaje"
                @select-hospedaje="handleSelectHospedaje"
            />
        </div>
    </div>
    <!-- Mapa con ubicaciones de hospedajes -->
    <div class="bg-gray-200 rounded-lg border border-gray-400 shadow-md h-[44rem]">
        <MapComponent
            :hospedajes="hosps"
            :selectedHospedajeId="selectedHospedajeId"
        />
    </div>
</div>
</template>
