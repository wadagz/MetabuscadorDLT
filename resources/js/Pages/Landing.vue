<script setup>
import '@splidejs/splide/css/sea-green';
import CarouselDestinos from '@/Components/CarouselDestinos.vue';
import SearchBar from '@/Components/SearchBar.vue';
import { useForm } from '@inertiajs/vue3';
import { formatDateToISO } from '@/Utils/dateFormatter.js';
import { toast } from 'vue3-toastify';

const props = defineProps({
    destinosPopulares: Array,
    destinosRecomendados: Array,
    nombresDestinos: Array,
    destino: String | null,
    fechaPartida: String | null,
    fechaRegreso: String | null,
    puntoPartida: String | null,
})

const today = new Date();
const aWeekLater = new Date();
aWeekLater.setDate(today.getDate() + 7);

// Corregir valores por defecto de este formulario cuando todavia no hay cookie.
const tomorrow = new Date();
const pasadoManana = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
pasadoManana.setDate(pasadoManana.getDate() + 2);

const form = useForm({
    destino: props.destino,
    fechaPartida: props.fechaPartida ? Date.parse(props.fechaPartida) : tomorrow.getTime(),
    fechaRegreso: props.fechaRegreso ? Date.parse(props.fechaRegreso) : pasadoManana.getTime(),
    puntoPartida: props.puntoPartida,
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
            // console.log(errors)
        }
    });

    form.get(route('searchHospedaje'), {
        onError: (errors) => {
            if (errors.destino == 'Ingrese un destino.') {
                toast(errors.destino, { type: 'info' });
            }
            else if (errors.destino == 'No se encontró el destino indicado.') {
                toast(errors.destino, { type: 'info' })
            }
            else if (errors.fechaPartida) {
                toast(errors.fechaPartida, { type: 'info' })
            }
            else if (errors.fechaRegreso) {
                toast(errors.fechaRegreso, { type: 'info' })
            }
            else if (errors.puntoPartida) {
                toast(errors.puntoPartida, { type: 'info' })
            }
            else {
                toast('Hubo un error', { type: 'error' });
            }
            console.log(errors)
        }
    });
};

</script>

<template>
<SearchBar
    :nombresDestinos="nombresDestinos"
    :destino="destino"
    :fechaPartida="fechaPartida"
    :fechaRegreso="fechaRegreso"
    :puntoPartida="puntoPartida"
/>
<div class="container mx-auto px-4 pt-4">
    <!-- Carousel para mastrar lista de hospedajes -->
    <h3 class="text-3xl py-4">Destinos Populares entre usuarios</h3>
    <CarouselDestinos
        @verDestino="verDestino"
        aria-label="Destinos Recomendados"
        :destinos="destinosPopulares"
    />

    <h3 class="text-3xl py-4">Destinos recomendados para ti</h3>
    <CarouselDestinos
        @verDestino="verDestino"
        aria-label="Destinos Recomendados"
        :destinos="destinosRecomendados"
    />

</div>
</template>
