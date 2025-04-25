<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
import { ref, onBeforeMount } from 'vue';

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
            <div
                v-for="rate in [1,2,3,4,5]"
                :key="rate"
                class="inline"
                :class="[ resena.calificacion < rate ? 'text-gray-300' : 'text-star']"
            >
                <Icon
                    :icon=" resena.calificacion < rate ? 'material-symbols-light:star-outline-rounded' : 'material-symbols-light:star'"
                    :width="30"
                    style="display: inline;"
                />
            </div>
        </div>
    </div>

    <hr class="my-1">

    <div class="pb-2">
        {{ resena.comentario }}
    </div>
</div>
</template>
