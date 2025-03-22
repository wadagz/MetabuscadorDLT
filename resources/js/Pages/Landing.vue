<script setup>
import '@splidejs/splide/css/sea-green';
import CarouselHospedajes from '../Components/CarouselHospedajes.vue';

defineProps({
    destinosPopulares: Array,
    destinosRecomendados: Array,
})
</script>

<template>
<div class="container mx-auto px-4 py-4">
    <!-- Carousel para mastrar lista de hospedajes -->
    <h3 class="text-3xl py-4">Destinos Populares entre usuarios</h3>
    <CarouselHospedajes
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
    <CarouselHospedajes
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
