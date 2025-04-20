<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
</script>

<template>
<div class="card bg-light m-4 px-2 border border-gray-300 rounded-sm">
    <div class="flex items-center justify-between">
        <div class="text-lg">
            <b>usuario</b>
        </div>
        <div>
            <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
            <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
            <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
            <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
            <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
        </div>
    </div>

    <hr class="my-1">

    <div class="pb-2">
        comentario
    </div>
</div>
</template>
