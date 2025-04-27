<script setup>
import { ref } from 'vue';
import ResenaCard from './Partials/ResenaCard.vue';
import LeafLetMap from './Partials/LeafLetMap.vue';
import Modal from '@/Components/Modal.vue'
import ResenaForm from './Partials/ResenaForm.vue';
import FavoriteHospedajeButton from '@/Components/FavoriteHospedajeButton.vue';
import { NButton } from 'naive-ui';
import CarouselHospedajes from '@/Components/CarouselHospedajes.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    hospedaje: Object,
    isLoggedIn: Boolean,
    similarHospedajes: Array,
});

const showModal = ref(false);

const addReview = () => {
    console.log('agregar reseña');
    showModal.value = true
};

</script>

<template>
<div class="card container mx-auto pt-4 pb-10">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl mb-4">{{ hospedaje.nombre }} - {{ hospedaje.destino.nombre }}</h1>
        <Link :href="route('planViaje.create')" >
            <NButton
                type="primary"
                color="#1ba10e"
                strong
            >
                REALIZAR PLAN DE VIAJE
            </NButton>
        </Link>
    </div>

    <!-- Info general del hospedaje -->
    <div class="grid grid-cols-3 gap-4 items-start">
        <!-- Imagen hospedaje -->
        <div class="card bg-light rounded-sm border border-gray-200 min-h-52 h-72 relative">
            <img :src="hospedaje.img_path" class="rounded-sm w-full h-full p-2"/>
            <div v-if="isLoggedIn" class="absolute bottom-4 right-4">
                <FavoriteHospedajeButton :hospedaje />
            </div>
        </div>

        <!-- Descripcion -->
        <div class="card bg-light border border-gray-200 rounded-sm p-2 min-h-52 h-72 flex flex-col" >
            <h2 class="text-2xl">
                Descripción
            </h2>

            <hr class="my-2">

            <div class="overflow-auto flex-1">
                {{ hospedaje.descripcion }}
            </div>
        </div>

        <!-- Amenidades -->
        <div class="card bg-light border border-gray-200 rounded-sm p-2 min-h-52 h-72 flex flex-col" >
            <h2 class="text-2xl">
                Amenidades incluidas
            </h2>

            <hr class="my-2">

            <div class="overflow-auto flex-1">
                <ul>
                    <li v-for="amenidad in hospedaje.amenidades" :key="amenidad.id" >
                        <p>
                            <b>{{ amenidad.nombre }}</b>
                        </p>
                        <p class="ml-4">
                            {{ amenidad.descripcion }}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mapa y reseñas -->
    <div class="grid grid-cols-2 grid-rows-[3em_auto] gap-x-4 mt-4">
        <!-- Títulos de mapa y reseñas -->
        <div class="max-h-32 flex items-end">
            <div class="mb-2 flex items-center justify-between">
                <p class="text-xl">
                    Ubicación
                </p>
            </div>
        </div>

        <div class="max-h-32">
            <div class="mb-2 flex items-end justify-between">
                <div class="text-xl flex justify-center gap-4">
                    <div>
                        Reseñas de usuarios
                    </div>

                    <div>
                        Calificacion promedio:
                    </div>
                </div>

                <NButton
                    secondary
                    strong
                    type="primary"
                    attr-type="button"
                    @click="addReview"
                >
                    Agregar reseña
                </NButton>
            </div>
        </div>

        <!-- Mapa y reseñas -->
        <div class="max-h-96">
            <LeafLetMap :hospedaje />
        </div>

        <div class="max-h-96 flex flex-col">
            <div class="bg-gray-200 rounded-sm border border-gray-400 shadow-md overflow-y-scroll flex-1">
                <ResenaCard v-for="i in [1,2,3,4,5,6,7,8,9,10]"/>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="text-xl mb-3">
            Hospedajes similares
        </div>

        <CarouselHospedajes
            :hospedajes="similarHospedajes"
        />
    </div>

</div>


<Modal v-if="showModal" @close="showModal = false">
    <template #title>
        <!-- Agregar un v-if para mostrar agregar o editar si el usuario ha resenado o no el hospedaje -->
        Agregar reseña
    </template>
    <template #body>
        <ResenaForm :hospedaje @close="showModal = false"/>
    </template>
</Modal>
</template>
