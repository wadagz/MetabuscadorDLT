<script setup>
import '@splidejs/splide/css/sea-green';
import { onMounted, ref } from 'vue';
import SearchBar from '@/Components/SearchBar.vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import axios from 'axios';

const props = defineProps({
    destinos: Array,
    nombresDestinos: Array,
    destino: String | null,
    fechaPartida: String | null,
    fechaRegreso: String | null,
    puntoPartida: String | null,
})

// Corregir valores por defecto de este formulario cuando todavia no hay cookie.
const tomorrow = new Date();
const pasadoManana = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
pasadoManana.setDate(pasadoManana.getDate() + 2);

const dateRange = ref([
    props.fechaPartida ? Date.parse(props.fechaPartida) : tomorrow.getTime(),
    props.fechaRegreso ? Date.parse(props.fechaRegreso) : pasadoManana.getTime(),
]);

const form = useForm({
    destino: props.destino,
    fechaPartida: props.fechaPartida ? Date.parse(props.fechaPartida) : tomorrow.getTime(),
    fechaRegreso: props.fechaRegreso ? Date.parse(props.fechaRegreso) : pasadoManana.getTime(),
    puntoPartida: props.puntoPartida ? props.puntoPartida : 'Guadalajara',
});

const verDestino = (destino_nombre) => {
    form.destino = destino_nombre;
    const fechaPartida = new Date(dateRange.value[0]);
    const fechaRegreso = new Date(dateRange.value[1]);
    form.fechaPartida = fechaPartida.toISOString();
    form.fechaRegreso = fechaRegreso.toISOString();
    form.get(route('searchHospedaje'), {
        onError: (errors) => {
            if (errors.destino == 'Ingrese un destino.') {
                toast(errors.destino, { type: 'info' });
            }
            if (errors.destino == 'No se encontró el destino indicado.') {
                toast(errors.destino, { type: 'error' })
            }
            else {
                toast('Hubo un error', { type: 'error' });
            }
            // console.log(errors)
        }
    });

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

// const city = ref(null)

// onMounted(() => {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(
//       async (position) => {
//         const lat = position.coords.latitude
//         const lon = position.coords.longitude

//         try {
//           const response = await axios.get('https://nominatim.openstreetmap.org/reverse', {
//             params: {
//               lat: lat,
//               lon: lon,
//               format: 'json',
//               addressdetails: 1
//             },
//             headers: {
//               'Accept-Language': 'es',
//               'User-Agent': 'TuAplicacion/1.0 (tucorreo@ejemplo.com)'
//             }
//           })

//           city.value = response.data.address.city ||
//                        response.data.address.town ||
//                        response.data.address.village ||
//                        response.data.address.hamlet ||
//                        'Ciudad no encontrada'
//         } catch (error) {
//           console.error('Error al consultar Nominatim:', error)
//           city.value = 'Error al obtener ciudad'
//         }
//       },
//       (error) => {
//         console.error('Error de geolocalización:', error)
//         city.value = 'Permiso de ubicación denegado o error'
//       }
//     )
//   } else {
//     city.value = 'Geolocalización no soportada'
//   }
// })
</script>

<template>
<SearchBar
    :nombresDestinos="nombresDestinos"
    :destino="destino"
    :fechaPartida="fechaPartida"
    :fechaRegreso="fechaRegreso"
    :puntoPartida="puntoPartida"
/>
<div class="container mx-auto px-4 pt-4 pb-10">
    <h3 class="text-3xl py-4">Algunos destinos que te podrían interesar</h3>

    <div class="grid grid-cols-5 gap-4">
        <div
            v-for="destino in destinos"
            @click="verDestino(destino.nombre)"
            class="bg-light p-2 rounded-sm border border-gray-400"
        >
            <div
                class="rounded-sm bg-white border border-gray-200 cursor-pointer"
            >
                <div>
                    <img
                        :src="destino.img_path"
                        class="h-32 w-full rounded-sm"
                    />
                </div>

                <div class="mb-2">
                    <div class="mx-4">
                        <div class="mt-1 truncate text-xl">
                            <b>{{  destino.nombre }}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>
