<script setup>
import { formatPrice } from '../../../Utils/priceFormatter';

const props = defineProps({
    hospedaje: Object,
})
</script>

<template>
    <div class="m-2 bg-light rounded-md border border-gray-400 shadow">
        <div class="grid grid-cols-2 ml-5 mt-2 mb-2 gap-4">
            <h2 class="text-lg">{{ props.hospedaje.nombre }}</h2>
            <p class="text-lg">Precio por noche: {{ formatPrice(props.hospedaje.precio) }}</p>
        </div>
        <hr class="mx-4 border border-primary-500">
        <div class="grid grid-cols-2">
            <div class="m-4">
                <img class="rounded-md max-w-full h-auto" src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/539157651.jpg?k=9c4e0dcc03b258ec5d24aa6224ac20cbf5668d1451d1b6e070863db52ad941b2&o=&hp=1">
            </div>
            <div class="grid grid-rows-4">
                <div class="m-4 row-span-3 overflow-auto max-h-36">
                    {{ props.hospedaje.descripcion }}
                </div>
                <div class="flex justify-center items-center align-middle">
                    <a :href="props.hospedaje.url" class="bg-primary-500 rounded-md text-white p-2 transition duration-300 hover:bg-primary-400">
                        Visitar sitio web
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
