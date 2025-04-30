<script setup>
import { onMounted, ref } from 'vue';
import Camino from './Camino.vue';

const props = defineProps({
    caminos: Object,
    viajeRedondo: Boolean,
})

const idxCaminoSeleccionado = ref(null);
const arregloReferenciaCaminoSeleccionado = ref([]);

const emits = defineEmits(['pathSelected']);

const selectPath = (camino, precio, tiempo, idx) => {
    idxCaminoSeleccionado.value = idx;
    console.log(idx)
    arregloReferenciaCaminoSeleccionado.value.forEach((element, arrIdx, arr) => {
        console.log(arrIdx)
        console.log(arrIdx === idx)
        arr[arrIdx] = arrIdx === idx;
    })
    console.log(arregloReferenciaCaminoSeleccionado.value)
    emits('pathSelected', camino, precio, tiempo)
}

onMounted(() => {
    for (let i = 0; i < props.caminos.length; i++) {
        arregloReferenciaCaminoSeleccionado.value.push(false);
    }
})
</script>

<template>
<div
    v-for="(camino, idx) in caminos"
    class="my-4 p-2 "
>
    <Camino
        :camino="camino"
        :viajeRedondo="viajeRedondo"
        :indexCamino="idx"
        :estaSeleccionado="arregloReferenciaCaminoSeleccionado[idx]"
        @pathSelected="selectPath"
    />

    <hr class="border border-gray-200 mt-8">
</div>
</template>
