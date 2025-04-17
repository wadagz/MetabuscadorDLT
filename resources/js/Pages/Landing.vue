<script setup>
import '@splidejs/splide/css/sea-green';
import CarouselDestinos from '@/Components/CarouselDestinos.vue';
import SearchBar from '@/Components/SearchBar.vue';
import { useForm } from '@inertiajs/vue3';
import { formatDateToISO } from '@/Utils/dateFormatter.js';
import { toast } from 'vue3-toastify';

defineProps({
    destinosPopulares: Array,
    destinosRecomendados: Array,
    nombresDestinos: Array,
})

const today = new Date();
const aWeekLater = new Date();
aWeekLater.setDate(today.getDate() + 7);

const form = useForm({
    destino: null,
    fechaPartida: formatDateToISO(today),
    fechaRegreso: formatDateToISO(aWeekLater),
    puntoPartida: null,
});

const verDestino = (destino_nombre) => {
    form.destino = destino_nombre;
    form.get(route('searchHospedaje'), {
        onError: (errors) => {
            if (errors.destino == 'Ingrese un destino.') {
                toast(errors.destino, { type: 'info' });
            }
            if (errors.destino == 'No se encontró el destino indicado.') {
                toast(errors.destino, { type: 'error' })
            }
            else {
                toast('Hubo un error', { type: 'error' });
            }
        }
    });
};

</script>

<template>
<SearchBar
    :nombresDestinos="nombresDestinos"
/>
<div class="container mx-auto px-4 pt-4">
    <!-- Carousel para mastrar lista de hospedajes -->
    <h3 class="text-3xl py-4">Destinos Populares entre usuarios</h3>
    <CarouselDestinos
        @verDestino="verDestino"
        aria-label="Destinos Recomendados"
        :splideOptions="{
            perPage: 4,
            perMove: 1,
            pagination: false,
            wheel: true,
            waitForTransition: true,
            gap: '1rem'
        }"
        :destinos="destinosPopulares"
    />

    <h3 class="text-3xl py-4">Destinos recomendados para ti</h3>
    <CarouselDestinos
        @verDestino="verDestino"
        aria-label="Destinos Recomendados"
        :splideOptions="{
            perPage: 4,
            perMove: 1,
            pagination: false,
            wheel: true,
            waitForTransition: true,
            gap: '1rem'
        }"
        :destinos="destinosRecomendados"
    />

</div>
</template>
