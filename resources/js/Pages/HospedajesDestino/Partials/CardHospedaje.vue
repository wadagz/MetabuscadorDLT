<script setup>
import { computed, inject } from 'vue';
import { formatPrice } from '../../../Utils/priceFormatter';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useForm, router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import FavoriteHospedajeButton from '@/Components/FavoriteHospedajeButton.vue';
import { NButton } from 'naive-ui';

const props = defineProps({
    hospedaje: Object,
})

const isLoggedIn = inject('isLoggedIn');

const visitHospedaje = () => {
    router.get(route('hospedaje.show', { hospedaje_id: props.hospedaje.id }));
}

const emit = defineEmits(['selectHospedaje']);

const selectHospedaje = () => {
    emit('selectHospedaje', props.hospedaje.id);
};
</script>

<template>
    <div @click="selectHospedaje" class="m-2 bg-light rounded-sm border border-gray-400 shadow cursor-pointer hover:bg-gray-100 transition-colors duration-200">
        <div class="grid grid-cols-2 ml-5 mt-2 mb-2 gap-4">
            <p class="text-lg">{{ props.hospedaje.nombre }}</p>
            <p class="text-lg">Precio por noche: {{ formatPrice(props.hospedaje.precio) }}</p>
        </div>

        <hr class="mx-4 border border-primary-500">

        <div class="grid grid-cols-2">
            <div class="m-4">
                <img class="rounded-sm w-full h-36 object-fill" :src="props.hospedaje.img_path">
            </div>

            <div class="">
                <div class="m-4 row-span-3 overflow-auto max-h-36">
                    {{ props.hospedaje.descripcion }}
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center align-middle mx-4 mb-2 gap-2">
            <div class="flex items-center">
                <span>Calificación:</span>
                <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
                <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
                <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
                <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
                <Icon icon="material-symbols-light:star-outline-rounded" :width="30" style="display: inline;"/>
            </div>

            <div class="flex justify-end items-center align-middle mr-4 gap-2">
                <FavoriteHospedajeButton v-if="isLoggedIn" :hospedaje />
                <NButton
                    @click="visitHospedaje"
                    type="primary"
                    attr-type="button"
                >
                    Visitar
                </NButton>
            </div>
        </div>
    </div>
</template>
