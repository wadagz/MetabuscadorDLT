<script setup>
import { ref } from 'vue';
import ResenaCard from './Partials/ResenaCard.vue';
import LeafLetMap from './Partials/LeafLetMap.vue';
import Modal from '@/Components/Modal.vue'
import ResenaForm from './Partials/ResenaForm.vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import FavoriteHospedajeButton from '@/Components/FavoriteHospedajeButton.vue';

const props = defineProps({
    hospedaje: Object,
    isLoggedIn: Boolean,
});

const showModal = ref(false);

const addReview = () => {
    console.log('agregar reseña');
    showModal.value = true
};

</script>

<template>
<div class="card container mx-auto pt-4">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl mb-4">{{ hospedaje.nombre }} - {{ hospedaje.destino.nombre }}</h1>
        <a
            href="https://google.com" class="rounded-md px-2 py-1 bg-primary-500 text-white transition duration-300 hover:bg-primary-400"
            >
            <b>
                VISITAR SITIO WEB
            </b>
        </a>
    </div>

    <!-- Info general del hospedaje -->
    <div class="grid grid-cols-3 gap-4 items-start">
        <!-- Imagen hospedaje -->
        <div class="card bg-light rounded-md border border-gray-200 min-h-52 h-72 relative">
            <img :src="hospedaje.img_path" class="rounded-md w-full h-full p-2"/>
            <div v-if="isLoggedIn" class="absolute bottom-4 right-4">
                <FavoriteHospedajeButton :hospedaje />
            </div>
        </div>

        <!-- Descripcion -->
        <div class="card bg-light border border-gray-200 rounded-md p-2 min-h-52 h-72 flex flex-col" >
            <h2 class="text-2xl">
                Descripción
            </h2>

            <hr class="my-2">

            <div class="overflow-auto flex-1">
                {{ hospedaje.descripcion }}
            </div>
        </div>

        <!-- Amenidades -->
        <div class="card bg-light border border-gray-200 rounded-md p-2 min-h-52 h-72 flex flex-col" >
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
    <div class="grid grid-cols-2 gap-4 mt-4">
        <div class="max-h-96">
            <div class="mb-2 flex items-center justify-between">
                <p class="text-xl">
                    Ubicación
                </p>
            </div>

            <LeafLetMap :hospedaje />
        </div>

        <div class="max-h-96 flex flex-col">
            <div class="mb-2 flex items-center justify-between">
                <div class="text-xl flex justify-center gap-4">
                    <div>
                        Reseñas de usuarios
                    </div>

                    <div>
                        Calificacion promedio:
                    </div>
                </div>

                <button @click="addReview" type="button" class="bg-primary-300 rounded-md text-white py-1 px-2 transition duration-300 hover:bg-primary-400">
                    Agregar reseña
                </button>
            </div>
            <div class="bg-gray-200 rounded-lg border border-gray-400 shadow-md overflow-y-scroll flex-1">
                <ResenaCard v-for="i in [1,2,3,4,5,6,7,8,9,10]"/>
            </div>
        </div>
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
