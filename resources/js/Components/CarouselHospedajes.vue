<script setup>
import { formatPrice } from '../Utils/priceFormatter';
import { router } from '@inertiajs/vue3';

defineProps({
    ariaLabel: String,
    hospedajes: Array,
})

const splideOptions = {
    type: 'slide',
    rewind: false,
    perPage: 4,
    perMove: 1,
    gap: '1rem',
    padding: {
        left: '1rem',
        right: '1rem'
    },
    pagination: false,
    drag: true,
}


const visitHospedaje = (hospedaje_id) => {
    router.get(route('hospedaje.show', { hospedaje_id: hospedaje_id }));
};
</script>

<template>
<div class="bg-light rounded-sm shadow mx-auto w-3/4">
    <Splide :options="splideOptions" aria-label="My Favorite Images">
        <SplideSlide v-for="hospedaje in hospedajes" :key="hospedaje.id">
            <div
                @click="visitHospedaje(hospedaje.id)"
                class="rounded-sm bg-white border border-gray-200 cursor-pointer"
            >
                <div>
                    <img
                        :src="hospedaje.img_path"
                        class="h-32 w-full rounded-sm"
                        :alt="hospedaje.nombre"
                    />
                </div>

                <div class="mb-2">
                    <div class="mx-4">
                        <div class="mt-1 truncate">
                            <b>{{  hospedaje.nombre }}</b>
                        </div>

                        <hr class="my-1">

                        <div>
                            <p>Precio por noche:</p>
                            <p>{{ formatPrice(hospedaje.precio) }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </SplideSlide>
    </Splide>
</div>
</template>

<style scoped>
:deep(.splide) {
    padding-top: 1em;
    padding-right: 3em;
    padding-bottom: 1em;
    padding-left: 3em;
}

:deep(.splide__arrow svg) {
    fill: #325d88;
}

:deep(.splide__arrow:hover svg) {
  fill: #8cb8ff;
}
</style>
