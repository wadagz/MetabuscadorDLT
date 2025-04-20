<script setup>
import CarouselHospedajes from '@/Components/CarouselHospedajes.vue';

const props = defineProps({
    favoritos: Object | null,
    destinos: Object,
});
</script>

<template>
<div class="container mx-auto pt-4">
    <h1 class="text-3xl">Mis hospedajes favoritos</h1>

    <div v-if="favoritos" v-for="(hospedajes, key) in favoritos" :key="key" class="my-4">
        <h2 class="text-2xl">{{ destinos[key] }}</h2>
        <div class="my-4">
            <a
                :href="route('user-favorites-in-destination', { 'destino_id': key })"
                class="bg-info rounded-md text-black p-2 transition duration-300 hover:bg-blue-300"
            >
                Ver lista de hospedajes
            </a>
        </div>

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
            :hospedajes="hospedajes"
        />
        <hr class="my-4">
    </div>

    <div v-else>
        No has agregado ningún hospedaje a tu lista de favoritos.
    </div>

</div>
</template>
