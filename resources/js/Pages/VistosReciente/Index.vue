<script setup>
import CarouselHospedajes from '@/Components/CarouselHospedajes.vue';

const props = defineProps({
    vistosReciente: Object | null,
});
</script>

<template>
<div class="container mx-auto pt-4">
    <h1 class="text-3xl">Hospedajes vistos recientemente</h1>

    <div v-if="!vistosReciente">
        <h2 class="text-xl">
            No has visto ningún hospedaje todavía.
        </h2>
    </div>

    <div v-else>
        <CarouselHospedajes
            aria-label="Mis favoritos"
            :splideOptions="{
                perPage: 4,
                perMove: 1,
                pagination: false,
                wheel: true,
                waitForTransition: true,
                gap: '1rem'
            }"
            :hospedajes="vistosReciente"
        />
    </div>


</div>
</template>
