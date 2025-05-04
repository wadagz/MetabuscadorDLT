<script setup>
import { NButton } from 'naive-ui';
import { formatPrice } from '@/Utils/priceFormatter';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    actividad: Object,
});

const viewActividad = () => {
    router.get(route('actividad.show', { 'actividadId': props.actividad.id }));
}
</script>

<template>
<div class="flex justify-between items-center">
    <span class="text-lg">
        <b>
            {{ actividad.nombre }}
        </b>
    </span>
    <span class="text-lg">
        Categoria: {{ actividad.categoria }}
    </span>
</div>

<hr>

<div class="overflow-auto max-h-36">
    {{ actividad.descripcion }}
</div>

<div class="flex justify-between items-center mt-2">
    <div>
        <b>Precio:</b> {{ formatPrice(actividad.precio) }}
    </div>
    <div>
        <NButton
            @click="viewActividad"
        >
            Ver más información
        </NButton>
    </div>
</div>
</template>
