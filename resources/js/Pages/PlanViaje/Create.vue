<script setup>
import { NButton } from 'naive-ui';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import Caminos from './Partials/Caminos.vue';
import BarraParametros from './Partials/BarraParametros.vue';
import LeafLetMap from '@/Components/LeafLetMap.vue';
import { toast } from 'vue3-toastify';
import { formatPrice } from '@/Utils/priceFormatter.js';
import { formatDateTimeString } from '@/Utils/dateFormatter';

const props = defineProps({
    destino: Object,
    fechaPartida: String,
    fechaRegreso: String,
    puntoPartida: String,
    viajeRedondo: Boolean,
    caminos: Object,
    hospedaje: Object,
})

const showModal = ref(false);

const showCaminos = ref(false);

const viajeRedondo = ref(props.viajeRedondo);

const toggleViajeRedondo = () => {
    viajeRedondo.value = !viajeRedondo.value;
};

const form = useForm({
    destinoId: props.destino.id,
    fechaPartida: props.fechaPartida,
    fechaRegreso: props.fechaRegreso,
    puntoPartida: props.puntoPartida,
    viajeRedondo: props.viajeRedondo,
    hospedajeId: props.hospedaje.id,
    caminoSeleccionado: null,
    precioTotal: null,
    tiempoTotal: null,
});

const selectPath = (path, precio, tiempo) => {
    form.caminoSeleccionado = path;
    form.precioTotal = precio + props.hospedaje.precio;
    form.tiempoTotal = tiempo;
};

const aViajar = () => {
    if (!form.caminoSeleccionado) {
        toast('Seleccione un camino de rutas.', { type: 'info' });
        return;
    }
    showModal.value = true;
}

const submit = () => {
    form.post(route('planViaje.store'), {
        onError: (errors) => {
            console.log(errors);
        }
    });
};

</script>

<template>
<div class="card container mx-auto pt-4 pb-10">
    <h1 class="text-3xl mb-4">Planificación de Viaje</h1>

    <!-- Barra de parámetros -->
    <div>
        <BarraParametros
            :fechaPartida
            :fechaRegreso
            :puntoPartida
            :viajeRedondo
            :hospedajeId="props.hospedaje.id"
            @toggleViajeRedondo="toggleViajeRedondo"
        />
    </div>

    <!-- Info de destino -->
    <div class="mt-4">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl">
                    {{ hospedaje.nombre }} - {{ destino.nombre }}
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-4 mt-4">
            <!-- Imagen hospedaje -->
            <div class="card bg-light rounded-sm border border-gray-200 min-h-52 h-72 relative">
                <img :src="hospedaje.img_path" class="rounded-sm w-full h-full p-2"/>
            </div>
            <!-- Mapa -->
            <div class="">
                <LeafLetMap :hospedaje />
            </div>
        </div>
    </div>

    <!-- Caminos de transporte sugeridos -->
    <div class="mt-10">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl">
                    Seleccione el camino de rutas que desee tomar para llegar al destino.
                </h2>
                <h2 class="text-lg">
                    {{ puntoPartida }} - {{ destino.nombre }}
                </h2>
            </div>
        </div>
        <div v-if="caminos">
            <Caminos
                :caminos="props.caminos"
                :viajeRedondo
                @pathSelected="selectPath"
            />
        </div>

        <div v-else class="flex justify-center">
            <h2 class="text-2xl">
                Ocurrió un problema al obtener las rutas de viaje.
            </h2>
        </div>
    </div>

    <div class="flex items-center justify-center">
        <button
            type="button"
            class="w-1/2 bg-primary-500 text-white p-2 transition duration-300 hover:bg-primary-400"
            @click="aViajar"
        >
            <span class="text-xl">
                !A viajar!
            </span>
        </button>
    </div>

</div>

<Modal v-if="showModal" @close="showModal = false">
    <template #title>
        <!-- Agregar un v-if para mostrar agregar o editar si el usuario ha resenado o no el hospedaje -->
        <span>Agendar mi viaje {{ puntoPartida }} - {{ destino.nombre }}</span>
    </template>
    <template #body>
        <div class="mb-4">
            <div class="text-lg">
                <b>Fechas:</b> {{ formatDateTimeString(fechaPartida) }} a {{ formatDateTimeString(fechaRegreso) }}.
            </div>
            <div class="text-lg">
                <b>Precio total:</b> {{ formatPrice(form.precioTotal) }}
            </div>
        </div>
        <div class="flex justify-center items-center">
            <NButton
                type="primary"
                strong
                @click="submit"
            >
                ¡Claro que sí!
            </NButton>
            <NButton
                type="secondary"
                strong
                @click="showModal = false"
            >
                Necesito pensarlo.
            </NButton>
        </div>
    </template>
</Modal>
</template>
