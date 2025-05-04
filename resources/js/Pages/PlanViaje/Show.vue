<script setup>
import { ref } from 'vue';
import Itinerario from './Partials/Itinerario.vue';
import LeafLetMap from '@/Components/LeafLetMap.vue';
import { formatPrice } from '@/Utils/priceFormatter.js';
import { NButton, NTooltip } from 'naive-ui';
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';
import MapaActividades from './Partials/MapaActividades.vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import ActividadCard from './Partials/ActividadCard.vue';

const props = defineProps({
    planViaje: Object,
    actividadesEventuales: Array,
    actividadesRecurrentes: Array,
    actividades: Array,
});

const showDeleteModal = ref(false);
const selectedActividadRecurrenteId = ref(null);
const selectedActividadEventualId = ref(null);

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const deletePlanDeViaje = () => {
    router.delete(route('planViaje.destroy', { planViajeId: props.planViaje.id }))
}
</script>

<template>
<div class="container mx-auto pt-4 pb-10">
    <h1 class="text-4xl mb-4">
        Tu plan de viaje
    </h1>
    <h2 class="text-2xl">
        {{ planViaje.punto_partida }} - {{ planViaje.destino }}
    </h2>

    <div class="grid grid-cols-2 gap-4 my-4">
        <div class="text-lg bg-light border border-gray-400 px-2 py-1 ">
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

        <div class="min-h-52">
            <LeafLetMap :hospedaje="props.planViaje.hospedaje" />
        </div>
    </div>

    <div>
        <h3 class="text-xl mb-2">
            Tu itinerario de viaje.
        </h3>
        <div class="flex">
            <Itinerario
                v-for="itinerario in props.planViaje.itinerarios"
                :key="itinerario.id"
                :itinerario="itinerario"
            />
        </div>
    </div>

    <div class="mt-4">
        <h1 class="text-2xl">Actividades que te podrían interesar en {{ planViaje.destino }}</h1>
        <h2 class="text-xl mt-4 mb-2 flex items-center gap-2">
            Actividades recurrentes en el destino turístico

            <NTooltip trigger="hover">
                <template #trigger>
                    <Icon icon="octicon:question-24" />
                </template>
                    Actividades que se llevan a cabo casi todos lo días.
            </NTooltip>
        </h2>

        <!-- Actividades recurrentes -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Listado de actividades en el destino -->
            <div class="bg-gray-200 rounded-sm overflow-auto max-h-[500px] border border-gray-400 p-2">
                <div
                    v-for="actividad in actividadesRecurrentes"
                    :key="actividad.id"
                    class="bg-light rounded-sm border border-gray-400 p-2 mb-2 cursor-pointer"
                    @click="selectedActividadRecurrenteId = actividad.id"
                >
                    <ActividadCard :actividad="actividad" />
                </div>
            </div>

            <!-- Mapa actividades recurrentes -->
            <div class="max-h-[500px]">
                <MapaActividades
                    :actividades="props.actividadesRecurrentes"
                    :selectedActividadId="selectedActividadRecurrenteId"
                />
            </div>
        </div>

        <h2 class="text-xl mt-4 mb-2 flex items-center gap-2">
            Actividades eventuales en el destino

            <NTooltip trigger="hover">
                <template #trigger>
                    <Icon icon="octicon:question-24" />
                </template>
                    Actividades que solo estarán disponibles por tiempo limitado.
            </NTooltip>
        </h2>

        <!-- Actividades recurrentes -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Listado de actividades en el destino -->
            <div class="bg-gray-200 rounded-sm overflow-auto max-h-[500px] border border-gray-400 p-2">
                <div
                    v-for="actividad in actividadesEventuales"
                    :key="actividad.id"
                    class="bg-light rounded-sm border border-gray-400 p-2 mb-2 cursor-pointer"
                    @click="selectedActividadEventualId = actividad.id"
                >
                    <ActividadCard :actividad="actividad" />
                </div>
            </div>

            <!-- Mapa actividades recurrentes -->
            <div class="max-h-[500px]">
                <MapaActividades
                    :actividades="props.actividadesEventuales"
                    :selectedActividadId="selectedActividadEventualId"
                />
            </div>
        </div>
    </div>

    <div class="mt-10">
        <div class="text-lg mb-2">
            Cancelar plan de viaje
        </div>
        <NButton
            type="warning"
            strong
            @click="openDeleteModal"
        >
            Cancelar plan de viaje
        </NButton>
    </div>
</div>

<Modal v-if="showDeleteModal" @close="closeDeleteModal">
    <template #title>
        Cancelar plan de viaje
    </template>
    <template #body>
        <div>
            <div class="text-lg">
                <b>¿Deseas proceder con la cancelación de tu plan de viaje?</b>
            </div>
            <div class="flex gap-4 justify-center items-center mt-2">
                <NButton
                    attr-type="button"
                    type="error"
                    strong
                    @click="deletePlanDeViaje"
                >
                    Sí, quiero proceder
                </NButton>
                <NButton
                    type="secondary"
                    strong
                    @click="closeDeleteModal"
                >
                    No, fue un error
                </NButton>
            </div>
        </div>
    </template>
</Modal>
</template>
