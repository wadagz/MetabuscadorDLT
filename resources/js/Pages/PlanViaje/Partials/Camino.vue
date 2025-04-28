<script setup>
import Ruta from './Ruta.vue';
import { NButton } from 'naive-ui';
import { formatPrice } from '@/Utils/priceFormatter.js';

const props = defineProps({
    camino: Object,
})

const getPrecioTotal = () => {
    let precioTotal = 0;
    props.camino.forEach(ruta => {
        precioTotal += ruta.precio;
    });

    return formatPrice(precioTotal);
}

const getTiempoTotal = () => {
    let tiempoTotal = 0;
    props.camino.forEach(ruta => {
        tiempoTotal += ruta.duracionMin;
    });

    return tiempoTotal;
}

// const

</script>

<template>
<div class="flex justify-between items-center">
    <div class="flex">
        <Ruta
            v-for="ruta in camino"
            :ruta="ruta"
        />
    </div>
    <div class="shrink">
        <div>
            <div class="flex justify-end gap-2">
                <b>Precio total:</b> {{ getPrecioTotal() }}
            </div>
            <div class="flex justify-end gap-2">
                <b>Tiempo de viaje:</b> {{ getTiempoTotal() }} min
            </div>
        </div>
        <div class="flex justify-end mt-2">
            <NButton
                type="primary"
                strong
            >
                Seleccionar
            </NButton>
        </div>
    </div>
</div>
</template>
