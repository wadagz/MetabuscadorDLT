<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
import { ref, onBeforeMount } from 'vue';
import CalificacionEstrellas from '@/Components/CalificacionEstrellas.vue';

const props = defineProps({
    usuarioConResena: Object,
});

const resena = ref(null);

onBeforeMount(() => {
    resena.value = props.usuarioConResena.pivot;
})
</script>

<template>
<div class="card bg-light m-4 px-2 border border-gray-300 rounded-sm">
    <div class="flex items-center justify-between">
        <div class="text-lg">
            <b>{{ usuarioConResena.name }}</b>
        </div>
        <div>
            <CalificacionEstrellas :calificacion="resena.calificacion"/>
        </div>
    </div>

    <hr class="my-1">

    <div class="pb-2">
        {{ resena.comentario }}
    </div>
</div>
</template>
