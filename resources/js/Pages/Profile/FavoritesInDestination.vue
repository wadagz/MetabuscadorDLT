<script setup>
const props = defineProps({
    hospedajes: Object,
    destino: Object,
});
</script>

<template>
<div class="container mx-auto pt-4">
    <h1 class="text-3xl">Mis hospedajes favoritos en {{ destino.nombre }}</h1>

    <div v-for="hospedaje in hospedajes" :key="hospedaje.id">
        <div class="bg-light rounded-md border border-gray-300 shadow mb-4 flex">
            <div class="w-1/2">
                <img src="https://el-tapatio-hotel-resort-guadalajara.hotel-dir.com/data/Photos/OriginalPhoto/6987/698705/698705568.JPEG">
            </div>
        </div>
    </div>

</div>
</template>
