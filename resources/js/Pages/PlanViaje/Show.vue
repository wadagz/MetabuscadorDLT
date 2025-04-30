<script setup>
import Itinerario from './Partials/Itinerario.vue';

const props = defineProps({
    planViaje: Object,
});
</script>

<template>
<div class="container mx-auto pt-4 pb-10">
    <h1 class="text-2xl">
        Tu plan de viaje
    </h1>
    <h2 class="text-xl">
        {{ planViaje.puntoPartida }} - {{ planViaje.destino }}
    </h2>

    <div>
        <span>
            Fecha de partida {{ planViaje.fechaComienzo }}
        </span>

        <span>
            Fecha de regreso {{ planViaje.fechaRegreso }}
        </span>

        <span>
            Viaje redondo {{ planViaje.viajeRedondo ? 'Sí' : 'No'}}
        </span>
    </div>

    <div>
        <h3 class=text-lg">
            Tu itinerario de viaje.
        </h3>
        <div class="flex">
            <Itinerario
                v-for="itinerario in props.planViaje.itinerarios"
                :key="itinerario.id"
                :itinerario="itinerario"
            />
        </div>
    </div>
</div>
</template>