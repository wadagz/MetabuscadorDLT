<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
import { onBeforeMount } from 'vue';

const props = defineProps({
    calificacion: Number | String,
})

</script>

<template>
<div class="inline">
    <div
        v-for="rate in [1,2,3,4,5]"
        :key="rate"
        class="inline"
        :class="[ calificacion < rate ? 'text-gray-500' : 'text-star']"
    >
        <Icon
            :icon=" calificacion < rate ? 'material-symbols-light:star-outline-rounded' : 'material-symbols-light:star'"
            :width="30"
            style="display: inline;"
        />
    </div>
</div>
</template>
