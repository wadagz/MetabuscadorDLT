<script setup>
import { onBeforeMount, provide, ref } from 'vue';
import SearchBar from '../../Components/SearchBar.vue';
import CardHospedaje from './Partials/CardHospedaje.vue';
import FilterBar from './Partials/FilterBar.vue';
import MapComponent from './Partials/LeafletMapComponent.vue';
import { toast } from 'vue3-toastify';

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
    amenidades: Object,
    isLoggedIn: Boolean,
    destinoId: Number,
    userId: Number | null,
});

const hosps = ref(null);

onBeforeMount(() => {
    hosps.value = props.hospedajes;
})

// Pass the isLoggedIn to child components, like the CardHospedaje component.
provide('isLoggedIn', props.isLoggedIn);

const showFilters = ref(false);

const toggleShowFilters = () => {
    showFilters.value = !showFilters.value
};

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
        userId: props.userId,
    };

    if (sort) {
        params.sort = [ ...sort]
    }

    // console.log(filters)
    // console.log(sort)
    // console.log(params);

    try {
        const response = await axios.get(route('filterHospedajes'), { params });
        // console.log(response.data);
        hosps.value = response.data;
    } catch(error) {
        console.log(error)
        console.log('Ocurrió un error.')
        toast('Ocurrión un error al aplicar los filtros.', { type: 'error' })
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
    :canFilter="true"
    @toggleShowFilters="toggleShowFilters"
/>

<Transition
    enter-active-class="transition duration-100 ease-out"
    enter-from-class="opacity-0 scale-75"
    enter-to-class="opacity-100 scale-100"
    leave-active-class="transition duration-100 ease-in"
    leave-from-class="opacity-100 scale-100"
    leave-to-class="opacity-0 scale-75"
>
    <div v-if="showFilters" class="container mx-auto">
        <FilterBar
            @filterChange="handleOnFilterChange"
            :amenidades
        />
    </div>
</Transition>

<div class="container mx-auto my-2">
    <h2 class="text-xl">
        Hospedajes encontrados en {{ destino }}
    </h2>
</div>

<div class="container mx-auto grid grid-cols-2 gap-4">
    <!-- Lista de hospedajes -->
    <div class="bg-gray-200 rounded-sm border border-gray-400 shadow-md overflow-y-scroll h-[44rem]">
        <div v-if="hosps.length > 0">
            <div v-for="hospedaje in hosps" :key="hospedaje.id">
                <CardHospedaje
                    :hospedaje="hospedaje"
                    @select-hospedaje="handleSelectHospedaje"
                />
            </div>
        </div>

        <!-- Mostrar mensaje cuando no hay hospedajes para mostrar. -->
        <div v-else class="m-2 bg-light rounded-sm border border-gray-400 shadow">
            <div class="flex items-center justify-center py-6">
                <p class="text-xl text-center">
                    No se encontraron hospedajes con los criterios indicados.
                </p>
            </div>
        </div>
    </div>
    <!-- Mapa con ubicaciones de hospedajes -->
    <div class="bg-gray-200 rounded-sm border border-gray-400 shadow-md h-[44rem]">
        <MapComponent
            :hospedajes="hosps"
            :selectedHospedajeId="selectedHospedajeId"
        />
    </div>
</div>
</template>
