<script setup>
import { computed, inject } from 'vue';
import { formatPrice } from '../../../Utils/priceFormatter';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useForm, router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const props = defineProps({
    hospedaje: Object,
})

const isLoggedIn = inject('isLoggedIn');

const isFavorite = computed(() => {
    return props.hospedaje.usuarios_que_dieron_favorito.length > 0;
})

const form = useForm({
    hospedaje_id: props.hospedaje.id,
});

const toggleFavorite = () => {
    if (isFavorite.value) {
        form.delete(route('remove-hospedaje-from-favorites', { 'hospedaje_id': form.hospedaje_id }), {
            onSuccess: () => {
                toast('Hospedaje eliminado de favoritos.', { type: 'success' });
            },
            onError: (error) => {
                toast(error.hospedaje_id, { type: 'error' });
            }
        })
    }
    else {
        form.post(route('add-hospedaje-to-favorites', { 'hospedaje_id': form.hospedaje_id }), {
            onSuccess: () => {
                toast('Hospedaje agregado a favoritos.', { type: 'success' })
            },
            onError: (error) => {
                toast(error.hospedaje_id, { type: 'error' });
            }
        })
    }
};

const visitHospedaje = () => {
    console.log('prueba')
    router.get(route('hospedaje.show', { hospedaje_id: props.hospedaje.id }));
}

const emit = defineEmits(['selectHospedaje']);

const selectHospedaje = () => {
    emit('selectHospedaje', props.hospedaje.id);
};
</script>

<template>
    <div @click="selectHospedaje" class="m-2 bg-light rounded-md border border-gray-400 shadow cursor-pointer hover:bg-gray-100 transition-colors duration-200">
        <div class="grid grid-cols-2 ml-5 mt-2 mb-2 gap-4">
            <p class="text-lg">{{ props.hospedaje.nombre }}</p>
            <p class="text-lg">Precio por noche: {{ formatPrice(props.hospedaje.precio) }}</p>
        </div>

        <hr class="mx-4 border border-primary-500">

        <div class="grid grid-cols-2">
            <div class="m-4">
                <img class="rounded-md w-full h-36 object-fill" :src="props.hospedaje.img_path">
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
                <button v-if="isLoggedIn" @click="toggleFavorite" class="bg-red-400 rounded-full p-3 transition duration-300 hover:bg-red-500">
                    <Icon :icon="isFavorite ? 'iconoir:heart-solid' : 'mdi:heart-outline'"/>
                </button>
                <button @click="visitHospedaje" type="button" class="bg-primary-500 rounded-md text-white p-2 transition duration-300 hover:bg-primary-400">
                    Visitar
                </button>
            </div>
        </div>
    </div>
</template>
