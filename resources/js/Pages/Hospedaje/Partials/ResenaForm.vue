<script setup>
import { ref } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useForm, router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { NButton, NInput } from 'naive-ui';
import axios from 'axios';

const props = defineProps({
    hospedaje: Object,
    resena: Object | null,
});

const emit = defineEmits(['close', 'resenaDeleted', 'listo'])

const calificacion = ref(props.resena ? props.resena.calificacion : 0);

const form = useForm({
    comentario: props.resena ? props.resena.comentario : '',
    calificacion: props.resena ? props.resena.calificacion : 0,
});

const submit = () => {
    if (props.resena) {
        form.patch(route('reviewHospedaje.update',
            {
                hospedaje_id: props.hospedaje.id,
            }),
            {
                onSuccess: () => {
                    toast('Reseña actualizada exitosamente.', { type: 'success' });
                    emit('close');
                    emit('listo');
                },
                onError: (errors) => {
                    console.log(errors)
                    for (const [key, value] of Object.entries(errors)) {
                        toast(value, { type: 'error' });
                    }
                },
            }
        )
    }
    else {
        form.post(route('reviewHospedaje.add', { hospedaje_id: props.hospedaje.id }), {
            onSuccess: (response) => {
                toast('Reseña publicada exitosamente.', { type: 'success' });
                emit('close');
                emit('listo');
                console.log(response)
            },
            onError: (errors) => {
                console.log(errors)
                for (const [key, value] of Object.entries(errors)) {
                    toast(value, { type: 'error' });
                }
            },
        });
    }
};

const deleteResena = async () => {
    try {
        const response = await axios.delete(route('reviewHospedaje.destroy', { resena_id: props.resena.id }));
        console.log(response)
        if (response.status === 200) {
            toast('Reseña eliminada exitosamente.', { type: 'success', });
            emit('resenaDeleted');
            emit('close');
            emit('listo');
        }
    }
    catch (error) {
        toast('Ocurrió un error al eliminar la reseña', { type: 'error' });
        console.log(error)
    }
}

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

        <div class="flex items-center justify-between">
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

            <div v-if="resena">
                <NButton
                    attr-type="button"
                    strong
                    primary
                    type="error"
                    @click="deleteResena"
                >
                    Eliminar Reseña
                </NButton>
            </div>
        </div>
    </form>
</div>
</template>
