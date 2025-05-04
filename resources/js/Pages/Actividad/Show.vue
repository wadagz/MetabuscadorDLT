<script setup>
import LeafLetMap from '@/Components/LeafLetMap.vue';
import HorariosEventuales from './Partials/HorariosEventuales.vue';
import HorariosRecurrentes from './Partials/HorariosRecurrentes.vue';
import { NButton } from 'naive-ui';
import { formatPrice } from '@/Utils/priceFormatter.js';


const props = defineProps({
    actividad: Object,
})
</script>

<template>
<div class="container mx-auto pt-4 pb-10">
    <h1 class="text-3xl">
        Actividad {{ actividad.nombre }} - {{ actividad.destino.nombre }}
    </h1>

    <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
            <div class="bg-light rounded-sm border border-gray-400 p-2">
                <div>
                    <span class="text-lg">
                        <b>Descripcion:</b>
                    </span>
                    {{ actividad.descripcion }}
                </div>

                <div>
                    <span class="text-lg">
                        <b>Categoria:</b>
                    </span>
                    {{ actividad.categoria }}
                </div>

                <div>
                    <span class="text-lg">
                        <b>Tipo de evento:</b>
                    </span>
                    {{ actividad.tipo }}
                </div>

                <div>
                    <span class="text-lg">
                        <b>Precio:</b>
                    </span>
                    {{ formatPrice(actividad.precio) }}
                </div>

                <div class="mt-4">
                    <NButton
                        type="secondary"
                    >
                        Agendar actividad
                    </NButton>
                </div>
            </div>

            <div class="bg-light rounded-sm border border-gray-400 p-2 mt-4">
                <HorariosRecurrentes
                    v-if="actividad.tipo === 'recurrente'"
                    :horarios="actividad.horarios_recurrentes"
                />
                <HorariosEventuales
                    v-else
                    :horarios="actividad.horarios_eventuales"
                />
            </div>
        </div>

        <div class="min-h-[500px]">
            <LeafLetMap :hospedaje="props.actividad" />
        </div>

    </div>
</div>
</template>
