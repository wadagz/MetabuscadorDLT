<script setup>
import { NButton } from 'naive-ui';
import { formatPrice } from '@/Utils/priceFormatter';
const props = defineProps({
    actividad: Object,
});
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
        >
            Ver más información
        </NButton>
    </div>
</div>
</template>
