<script setup>
import { NButton, NDatePicker, NInput, NSwitch, NTooltip } from 'naive-ui';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';

const props = defineProps({
    fechaPartida: String,
    fechaRegreso: String,
    puntoPartida: String,
    viajeRedondo: Boolean,
    hospedajeId: Number,
})

const emits = defineEmits(['toggleViajeRedondo']);

const dateRange = ref([
    Date.parse(props.fechaPartida),
    Date.parse(props.fechaRegreso),
]);

const form = useForm({
    fechaPartida: dateRange.value[0],
    fechaRegreso: dateRange.value[1],
    puntoPartida: props.puntoPartida,
    viajeRedondo: props.viajeRedondo,
    hospedajeId: props.hospedajeId,
});

const submit = () => {
    form.viajeRedondo = props.viajeRedondo;
    const fechaPartida = new Date(dateRange.value[0]);
    const fechaRegreso = new Date(dateRange.value[1]);
    form.fechaPartida = fechaPartida.toISOString();
    form.fechaRegreso = fechaRegreso.toISOString();
    form.post(route('planViaje.updateParameters'));
}
</script>

<template>
<div class="max-w-xl xl:max-w-7xl mx-auto rounded-sm">
    <form @submit.prevent="submit">
        <div class="flex flex-row justify-evenly gap-2">

            <!-- Punto de Partida -->
            <div class="flex-grow grid grid-rows-2 items-end">
                <div class="mb-2 flex justify-center">
                    <label class="">Punto de partida</label>
                </div>
                <NInput
                    v-model:value="form.puntoPartida"
                    type="text"
                    placeholder="E.j. Guadalajara"
                    clearable
                />
            </div>

            <!-- Rango de fechas -->
            <div class="flex-grow grid grid-rows-2 items-end">
                <div class="mb-2 flex justify-center">
                    <label for="fechas" class="">Fecha de partida y regreso</label>
                </div>
                <NDatePicker
                    v-model:value="dateRange"
                    type="daterange"
                    clearable
                    id="fechas"
                    name="fechas"
                />
            </div>

            <div class="flex-shrink grid grid-rows-2">
                <div class="flex items-center gap-2">
                    <label>Viaje redondo</label>
                    <NTooltip trigger="hover">
                        <template #trigger>
                            <Icon icon="octicon:question-24" />
                        </template>
                            Tomar las mismas rutas en sentido opuesto
                    </NTooltip>
                </div>
                <div class="flex items-center justify-center">
                    <NSwitch
                        :round="false"
                        @update-value="emits('toggleViajeRedondo')"
                    >
                        <template #checked>
                            Ida y vuelta
                        </template>
                        <template #unchecked>
                            Solo ida
                        </template>
                    </NSwitch>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-shrink text-center items-end justify-end gap-2">
                <NButton
                    type="primary"
                    attr-type="submit"
                    strong
                    @click="submit"
                >
                    <!-- <template #icon>
                        <Icon icon="material-symbols:trip-outline" />
                    </template> -->
                    Actualizar datos
                </NButton>
            </div>
        </div>
    </form>
</div>
</template>
