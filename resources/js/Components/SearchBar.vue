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
    canFilter: Boolean,
});

const emit = defineEmits(['toggleShowFilters']);

const tomorrow = new Date();
const pasadoManana = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
pasadoManana.setDate(pasadoManana.getDate() + 2);

const dateRange = ref([
    props.fechaPartida ? Date.parse(props.fechaPartida) : tomorrow.getTime(),
    props.fechaRegreso ? Date.parse(props.fechaRegreso) : pasadoManana.getTime(),
]);
// const dateRange = ref([Date.now(), Date.now()]);

const form = useForm({
    destino: props.destino ? props.destino : '',
    fechaPartida: dateRange.value[0],
    fechaRegreso: dateRange.value[1],
    puntoPartida: props.puntoPartida ? props.puntoPartida : '',
});

const submit = () => {
    const fechaPartida = new Date(dateRange.value[0]);
    const fechaRegreso = new Date(dateRange.value[1]);
    form.fechaPartida = fechaPartida.toISOString();
    form.fechaRegreso = fechaRegreso.toISOString();
    // console.log(form.fechaPartida)
    // console.log(form.fechaRegreso)
    // return
    form.get(route('searchHospedaje'), {
        onError: (errors) => {
            if (errors.destino == 'Ingrese un destino.') {
                toast(errors.destino, { type: 'info' });
            }
            else if (errors.destino == 'No se encontró el destino indicado.') {
                toast(errors.destino, { type: 'info' })
            }
            else if (errors.fechaPartida) {
                toast(errors.fechaPartida, { type: 'info' })
            }
            else if (errors.fechaRegreso) {
                toast(errors.fechaRegreso, { type: 'info' })
            }
            else if (errors.puntoPartida) {
                toast(errors.puntoPartida, { type: 'info' })
            }
            else {
                toast('Hubo un error', { type: 'error' });
            }
            console.log(errors)
        }
    });
};

</script>

<template>
<div class="max-w-xl xl:max-w-7xl mx-auto rounded-sm">
    <form @submit.prevent="submit">
        <div class="flex flex-row justify-evenly gap-2">

            <!-- Destino o lugar turístico -->
            <div class="flex-grow grid grid-rows-2 items-end">
                <label for="destino" class="">Destino o lugar turístico</label>
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

            <!-- Rango de fechas -->
            <div class="flex-grow grid grid-rows-2 items-end">
                <label for="fechas" class="">Fecha de partida y regreso</label>
                <NDatePicker
                    v-model:value="dateRange"
                    type="daterange"
                    clearable
                    id="fechas"
                    name="fechas"
                />
            </div>

            <!-- Punto de Partida -->
            <div class="grid grid-rows-2 items-end">
                <label class="">Punto de partida</label>
                    <NInput
                    v-model:value="form.puntoPartida"
                    type="text"
                    placeholder="E.j. Guadalajara"
                    clearable
                    />
            </div>

            <!-- Botones -->
            <div class="flex flex-shrink text-center items-end justify-end gap-2">
                <NButton
                    type="primary"
                    attr-type="submit"
                    strong
                    @click="submit"
                >
                    <template #icon>
                        <Icon icon="material-symbols:search" />
                    </template>
                    Buscar
                </NButton>
                <NButton
                    v-if="canFilter"
                    secondary
                    attr-type="button"
                    strong
                    @click="emit('toggleShowFilters')"
                >
                    <template #icon>
                        <Icon icon="mdi:filter" />
                    </template>
                    Filtros
                </NButton>
            </div>
        </div>
    </form>
</div>
</template>
