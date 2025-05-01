<script setup>
import Ruta from './Ruta.vue';
import { NButton } from 'naive-ui';
import { formatPrice } from '@/Utils/priceFormatter.js';
import { onMounted, reactive, ref, watch } from 'vue';

const props = defineProps({
    camino: Object,
    viajeRedondo: Boolean,
    indexCamino: Number,
    estaSeleccionado: Boolean,
})

const emits = defineEmits(['pathSelected'])

const precioTotal = ref(0);
const tiempoTotal = ref(0);
// const seleccionado = ref(props.estaSeleccionado);

const getPrecioTotal = () => {
    let total = 0;
    props.camino.forEach(ruta => {
        total += ruta.precio;
    });

    if (props.viajeRedondo) {
        total = total + (total * 0.8);
    }

    return total;
}

const getTiempoTotal = () => {
    let total = 0
    props.camino.forEach(ruta => {
        total += ruta.duracion_min;
    });

    return total;
}

const selectPath = () => {
    // console.log(props.camino);
    // props.estaSeleccionado = true;
    emits('pathSelected', props.camino, precioTotal.value, tiempoTotal.value, props.indexCamino);
}

watch(() => props.viajeRedondo, () => {
    precioTotal.value = getPrecioTotal();
    tiempoTotal.value = getTiempoTotal();
})

onMounted(() => {
    precioTotal.value = getPrecioTotal();
    tiempoTotal.value = getTiempoTotal();
})

</script>

<template>
<div class="flex justify-between items-center gap-4" :class="{ 'bg-primary-300': estaSeleccionado, 'bg-opacity-10': estaSeleccionado }">
    <div class="flex">
        <Ruta
            v-for="ruta in camino"
            :ruta="ruta"
        />
    </div>
    <div class="shrink">
        <div>
            <div class="flex justify-end gap-2">
                <b>Precio de viaje:</b> {{ formatPrice(precioTotal) }}
            </div>
            <div class="flex justify-end gap-2">
                <b>Tiempo de viaje:</b> {{ tiempoTotal }} min
            </div>
        </div>
        <div class="flex justify-end mt-2">
            <NButton
                type="primary"
                strong
                :color="props.estaSeleccionado ? '#849eb8' : '#5b7da0'"
                @click="selectPath"
            >
                {{ props.estaSeleccionado ? 'Seleccionado' : 'Seleccionar' }}
            </NButton>
        </div>
    </div>
</div>
</template>
