<script setup>
import { ref } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { NButton, NDatePicker, NInput } from 'naive-ui';

// Será necesario cambiar los props para cuando tengamos definidos los hospedajes y la forma de buscarlos.
const props = defineProps({
    destino: String | null,
    fechaPartida: String | null,
    fechaRegreso: String | null,
    puntoPartida: String | null,
    nombresDestinos: Array,
});

const dateRange = ref([Date.now(), Date.now()]);

const form = useForm({
    destino: props.destino,
    fechaPartida: props.fechaPartida,
    fechaRegreso: props.fechaRegreso,
    puntoPartida: props.puntoPartida,
});

const submit = () => {
    form.fechaPartida = dateRange.value[0];
    form.fechaRegreso = dateRange.value[1];
    form.get(route('searchHospedaje'), {
        onError: (errors) => {
            if (errors.destino == 'Ingrese un destino.') {
                toast(errors.destino, { type: 'info' });
            }
            else if (errors.destino == 'No se encontró el destino indicado.') {
                toast(errors.destino, { type: 'error' })
            }
            else {
                toast('Hubo un error', { type: 'error' });
            }
        }
    });
};

</script>

<template>
<div class="mt-4 bg-light max-w-xl xl:max-w-7xl mx-auto rounded-md border border-gray-400">
    <form @submit.prevent="submit">
        <!-- <div class="flex flex-nowrap items-center justify-between gap-2"> -->
        <div class="grid grid-cols-4 gap-2">
            <div class="grid grid-rows-2 items-end">
                <label for="destino" class="">Destino o lugar turístico</label>
                <!-- <Icon icon="material-symbols:search" /> -->
                <!-- <input name="destiono" type="text" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" list="nomsDestinos" placeholder="E.j. Puerto Vallarta" v-model="form.destino"> -->
                <NInput
                    v-model:value="form.destino"
                    type="text"
                    placeholder="Destino o lugar turístico"
                    id="destino"
                    name="destino"
                    :input-props="{ list: 'nomsDestinos' }"
                    list="nomsDestinos"
                    clearable
                >
                    <template #prefix>
                        <Icon icon="material-symbols:search" />
                    </template>
                </NInput>
                <datalist id="nomsDestinos">
                    <option v-for="destino in nombresDestinos" :value="destino">
                        {{ destino }}
                    </option>
                </datalist>
            </div>

            <div class="grid grid-rows-2 items-end">
                <label for="fechas" class="">Fecha de partida y regreso</label>
                <NDatePicker
                    v-model:value="dateRange"
                    type="daterange"
                    clearable
                    id="fechas"
                    name="fechas"
                />
                <!-- <Icon icon="mdi:calendar-month-outline" />
                <input name="fechaPartida" type="date" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" v-model="form.fechaPartida">
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Fecha de regreso</label>
                <Icon icon="mdi:calendar-month-outline" />
                <input name="fechaRegreso" type="date" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" v-model="form.fechaRegreso"> -->
            </div>

            <div class="grid grid-rows-2 items-end">
                <label class="">Punto de partida</label>
                <!-- <Icon icon="mdi:location" /> -->
                <!-- <input name="puntoPartida" type="text" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Guadalajara" v-model="form.puntoPartida"> -->
                 <NInput
                    v-model:value="form.puntoPartida"
                    type="text"
                    placeholder="E.j. Guadalajara"
                    clearable
                 />
            </div>
            <div class="flex flex-grow text-center items-end justify-center">
                <button
                    type="submit"
                    class="rounded-sm bg-primary-500 w-1/2 py-1 text-white transition duration-300 hover:bg-primary-400">
                    Buscar
                </button>
                <!-- <NButton
                    type="primary"
                    attr-type="submit"
                >
                    Buscar
                </NButton> -->
            </div>
        </div>
    </form>
</div>
</template>
