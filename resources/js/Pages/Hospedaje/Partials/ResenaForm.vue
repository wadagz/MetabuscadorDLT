<script setup>
import { ref } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useForm, router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { NButton, NInput } from 'naive-ui';

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
                <NInput
                    v-model:value="form.comentario"
                    type="textarea"
                    placeholder="Cómo te la pasaste."
                    id="comentario"
                />
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
            <NButton
                attr-type="submit"
                strong
                type="primary"
            >
                Finalizar
            </NButton>
            <NButton
                attr-type="button"
                strong
                secondary
                @click="emit('close')"
            >
                Cancelar
            </NButton>
        </div>
    </form>
</div>
</template>
