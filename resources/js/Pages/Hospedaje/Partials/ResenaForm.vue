<script setup>
import { ref } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useForm, router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const props = defineProps({
    hospedaje: Object,
});

const emit = defineEmits(['close'])

const calificacion = ref(0);

const form = useForm({
    comentario: '',
    calificacion: 0,
});

const submit = () => {
    form.post(route('reviewHospedaje.add', { hospedaje_id: props.hospedaje.id }), {
        onSuccess: () => {
            toast('Reseña publicada exitosamente.', { type: 'success' });
            emit('close');
        },
        onError: (errors) => {
            console.log(errors)
            for (const [key, value] of Object.entries(errors)) {
                toast(value, { type: 'error' });
            }
        },
    });
};

const setCalificacion = (rate) => {
    calificacion.value = rate;
    form.calificacion = calificacion.value;
};
</script>

<template>
<div class="w-full">
    <form @submit.prevent="submit">
        <div>
            <div class="w-full">
                <label for="comentario" >
                    <p class="text-gray-500 mb-2">
                        Cuéntale a los demás tu experiencia
                    </p>
                </label>
                <textarea v-model="form.comentario" id="comentario" class="w-full">
                </textarea>
            </div>

            <div class="mt-4">
                <label for="calificacion">
                    <p class="text-gray-500">
                        ¿Qué calificación le das?
                    </p>
                </label>
                <div
                    v-for="rate in [1,2,3,4,5]"
                    :key="rate"
                    class="inline"
                    :class="[ calificacion < rate ? 'text-gray-300' : 'text-star']"
                >
                    <button type="button" @click="setCalificacion(rate)">
                        <Icon
                            :icon=" calificacion < rate ? 'material-symbols-light:star-outline-rounded' : 'material-symbols-light:star'"
                            :width="30"
                        />
                    </button>
                </div>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="rounded-md mt-4 py-1 px-2 bg-primary-500 text-white transition duration-300 hover:bg-primary-400">
                <b>Finalizar</b>
            </button>
            <button @click="emit('close')" type="button" class="rounded-md mt-4 py-1 px-2 bg-secondary text-white transition duration-300 hover:bg-gray-400">
                <b>Cancelar</b>
            </button>
        </div>
    </form>
</div>
</template>
