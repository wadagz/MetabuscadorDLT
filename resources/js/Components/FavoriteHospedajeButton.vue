<script setup>
import { computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { toast } from 'vue3-toastify';

const props = defineProps({
    hospedaje: Object,
})

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

</script>

<template>
<button @click="toggleFavorite" class="bg-red-400 rounded-full p-3 transition duration-300 hover:bg-red-500">
    <Icon :icon="isFavorite ? 'iconoir:heart-solid' : 'mdi:heart-outline'"/>
</button>
</template>
