<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
import { formatPrice } from '@/Utils/priceFormatter';

const props = defineProps({
    ruta: Object,
})
</script>

<template>
<div class="bg-light mx-2 border border-gray-400 rounded-sm p-2">
    <div class="flex items-center justify-center gap-2 text-lg">
        <b>{{ ruta.nombreOrigen }}</b>
        <Icon icon="charm:arrow-right" />
        <b>{{ ruta.nombreTarget }}</b>
    </div>
    <hr class="mt-2">
    <div class="flex justify-between items-center gap-4">
        <span>
            Distancia: {{ ruta.distancia }} km
        </span>
        <span>
            Duración viaje: {{ ruta.duracionMin }} min.
        </span>
    </div>
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span>
                Tipo:
            </span>
            <span>
                <Icon :icon="ruta.tipo == 'Avión' ? 'mdi:airplane' : 'mingcute:bus-2-fill'" :size="40"/>

            </span>
        </div>
        <div>
            Precio: {{ formatPrice(ruta.precio) }}
        </div>
    </div>
</div>
</template>
