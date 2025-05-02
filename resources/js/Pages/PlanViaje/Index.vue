<script setup>
import { formatPrice } from '@/Utils/priceFormatter.js';
import { NButton } from 'naive-ui';
import { router } from '@inertiajs/vue3';

const props = defineProps({
   planesViaje: Array,
});

const viewPlanViaje = (planViajeId) => {
    router.get(route('planViaje.show', { 'planViajeId': planViajeId }));
}
</script>

<template>
<div class="container mx-auto pt-4 pb-10">
    <h1 class="text-4xl">
        Tus planes de viaje
    </h1>

    <div v-if="planesViaje.length > 0" class="mt-4">
        <div
            v-for="planViaje in planesViaje"
            :key="planViaje.id"
            class="grid grid-cols-2 gap-2"
        >
            <div class="bg-light border border-gray-400 p-4 rounded-sm flex flex-col justify-between">
                <div>
                    <div class="text-xl">
                        {{ planViaje.punto_partida }} - {{ planViaje.destino }}
                    </div>
                    <div class="text-lg pl-10">
                        <div>
                            <b>Fecha de partida:</b> {{ planViaje.fecha_comienzo }}
                        </div>

                        <div>
                            <b>Fecha de regreso:</b> {{ planViaje.fecha_fin }}
                        </div>

                        <div>
                            <b>Viaje redondo:</b> {{ planViaje.viajeRedondo ? 'Sí' : 'No'}}
                        </div>
                        <div>
                            <b>Precio hospedaje:</b> {{ formatPrice(planViaje.hospedaje.precio) }}
                        </div>
                        <div>
                            <b>Precio viaje:</b> {{ formatPrice(planViaje.precio - planViaje.hospedaje.precio) }}
                        </div>
                        <div>
                            <b>Precio total:</b> {{ formatPrice(planViaje.precio) }}
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-lg">
                        Ver plan de viaje
                    </div>
                    <NButton
                        type="primary"
                        strong
                        @click="viewPlanViaje(planViaje.id)"
                    >
                        Ver plan de viaje
                    </NButton>
                </div>
            </div>

            <div class="card bg-light rounded-sm border border-gray-200 min-h-52 h-72 relative">
                <img :src="planViaje.hospedaje.img_path" class="rounded-sm w-full h-full p-2"/>
            </div>
        </div>
    </div>

    <div v-else class="text-2xl">
        No tienes planes de viaje registrados.
    </div>
</div>
</template>
