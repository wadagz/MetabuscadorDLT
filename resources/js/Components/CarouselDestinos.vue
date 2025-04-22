<script setup>
import { formatPrice } from '../Utils/priceFormatter';

defineProps({
    ariaLabel: String,
    splideOptions: {},
    destinos: Array,
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

const emit = defineEmits(['verDestino']);
</script>

<template>
<div class="bg-light rounded-sm shadow mx-auto w-3/4">
    <Splide :options="splideOptions" aria-label="My Favorite Images">
        <SplideSlide v-for="destino in destinos" :key="destino.id">
            <div
                @click="emit('verDestino', destino.nombre)"
                class="rounded-sm bg-white border border-gray-200 cursor-pointer"
            >
                <div>
                    <img
                        :src="destino.img_path"
                        class="h-32 w-full rounded-sm"
                    />
                </div>

                <div class="mb-2">
                    <div class="mx-4">
                        <div class="mt-1 truncate">
                            <b>{{  destino.nombre }}</b>
                        </div>

                        <hr class="my-1">

                        <div>
                            <p>Precio por noche:</p>
                            <p>{{ formatPrice(destino.precio_promedio) }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </SplideSlide>
    </Splide>
</div>
</template>

<style scoped>
/* Deep selector for Vue 3 + Tailwind */
:deep(.splide) {
    padding-top: 2em;
    padding-right: 3em;
    padding-bottom: 2em;
    padding-left: 3em;
}

:deep(.splide__arrow svg) {
    fill: #325d88;
}

:deep(.splide__arrow:hover svg) {
  fill: #8cb8ff;
}
</style>

