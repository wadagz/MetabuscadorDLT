<script setup>
import { ref, inject, watch, onBeforeUnmount, onMounted } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import Fuse from 'fuse.js';

const props = defineProps({
    amenidades: Object,
});

const emit = defineEmits(['filterChange']);

// Refs para el listado de amenidades
const showAmenidades = ref(false);
const amenidadesSearchQuery = ref('');
const amenidadesToShow = ref(props.amenidades);
// Ref para cerrar dorpdown menu al hacer click fuere de este
const dropdownRef = ref(null)

const amenidadesSeleccionadas = ref([]);

// Config of fuse for fuzzy search.
const fuse = new Fuse(props.amenidades, {
    keys: ['nombre', 'descripcion'],
    includeScore: true,
    threshold: 0.4, // lower = stricter
});

// Filters structure compatible with Laravel Purity
const filters = ref({
    precio: { $lte: 5000 },
    amenidades: {
        id: {
            $in: amenidadesSeleccionadas,
        },
    },
});

// Ordenamiento por columna y dirección
const sort = ref({
    field: 'nombre',
    direction: 'asc'
});

// Aplica los filtros seleccionados
function applyFilters() {
  // Remove empty filter values
  const cleanFilters = JSON.parse(JSON.stringify(filters.value));
  Object.keys(cleanFilters).forEach(key => {
    if (typeof cleanFilters[key] === 'object') {
      // Remove empty object properties
      Object.keys(cleanFilters[key]).forEach(subKey => {
        if (cleanFilters[key][subKey] === null || cleanFilters[key][subKey] === '') {
          delete cleanFilters[key][subKey];
        }
      });

      // Remove empty objects
      if (Object.keys(cleanFilters[key]).length === 0) {
        delete cleanFilters[key];
      }
    } else if (cleanFilters[key] === null || cleanFilters[key] === '') {
      delete cleanFilters[key];
    }
  });

  // Emite la señal para que el componente padre haga fetch con los nuevos filtros.
  emit('filterChange', {
    filters: cleanFilters,
    sort: sort.value.field ? sort.value : null
  });
};

// Debounce function para esperar 300 ms
function debounce(fn, delay = 300) {
  let timeout
  return (...args) => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
      fn(...args)
    }, delay)
  }
}

// Actualizar el listado de amenidades
const updateAmenidadesToShow = debounce((search) => {
    if (!search) {
        amenidadesToShow.value = props.amenidades;
        return;
    }

    const matches = fuse.search(search);
    console.log(matches)
    amenidadesToShow.value = matches.map(result => result.item);
}, 300)

// Watcher para actualizar el listado de amenidades
watch(amenidadesSearchQuery, (newVal) => {
    updateAmenidadesToShow(newVal);
});

// Función para cerrar el dropdown menu de amenidades al hacer click fuere de este
function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    showAmenidades.value = false
  }
}

const handleAmenidadCheckBox = (amenidadId) => {
    const index = amenidadesSeleccionadas.value.indexOf(amenidadId);
    if (index === -1) {
        amenidadesSeleccionadas.value.push(amenidadId);
    }
    else {
        amenidadesSeleccionadas.value.splice(index, 1);
    }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <div class="mt-4 bg-light max-w-xl xl:max-w-7xl mx-auto rounded-md border border-gray-400">
        <div class="flex flex-nowrap items-center justify-evenly">
            <!-- Selección de ordenamiento -->
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Ordenar</label>
                <Icon icon="material-symbols:sort" />
                <select v-model="sort.direction" name="destino" class="w-11/12 rounded-md mb-2 mt-1 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option value="asc">A a la Z</option>
                    <option value="desc">Z a la A</option>
                </select>
            </div>

            <!-- Selección de rango de precio -->
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Precio</label>
                <Icon icon="mdi:cash" />
                <select v-model="filters.precio.$lte"  name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option value="5000">Hasta $5,000</option>
                    <option value="10000">Hasta $10,000</option>
                    <option value="20000">Hasta  $20,000</option>
                </select>
            </div>

            <!-- Selección de amenidades -->
            <div class="flex-grow text-center grid grid-col-4 items-center justify-center">
                <label class="col-start-1 col-span-4 mt-1">Precio</label>
                <Icon icon="mdi:cash" />
                <div class="relative inline-block text-left" ref="dropdownRef">
                    <div>
                        <button
                            type="button"
                            @click="showAmenidades = !showAmenidades"
                            class="rounded-md bg-cyan-700 text-white px-2 py-1"
                        >
                            Seleccionar Amenidades
                        </button>
                    </div>

                    <!-- Dropdown menu para seleccionar amenidades -->
                    <Transition
                        enter-active-class="transition duration-100 ease-out"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition duration-100 ease-in"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div
                            v-if="showAmenidades"
                            class="origin-top-right mt-2 w-96 rounded-md shadow-lg bg-white ring-1
                                ring-black ring-opacity-5 focus:outline-none z-[9999] max-h-96 overflow-scroll
                                absolute top-10 p-4
                            "
                        >
                            <!-- Input para buscar amenidades en concreto -->
                            <div class="mb-2 flex items-center gap-2">
                                <input v-model="amenidadesSearchQuery" class="max-h-6 w-full">
                            </div>

                            <hr>

                            <!-- Lista de amenidades -->
                            <div v-for="amenidad in amenidadesToShow" :key="amenidad.id" class="transition duration-75 hover:bg-gray-100">
                                <div class="flex items-center pl-1 py-2 ">
                                    <input
                                    @click="handleAmenidadCheckBox(amenidad.id)"
                                    type="checkbox"
                                    :id="amenidad.nombre"
                                    :checked="amenidadesSeleccionadas.indexOf(amenidad.id) !== -1"
                                    />
                                    <label :for="amenidad.nombre" class="ml-2 w-full">
                                        {{ amenidad.nombre }}
                                    </label>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>


            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Cant. Personas</label>
                <Icon icon="mdi:account-multiple" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>

            <div class="flex-grow text-center">
                <button @click="applyFilters" type="button" class="rounded-md bg-primary-500 w-11/12 py-1 mr-2 mt-6 text-white transition duration-300 hover:bg-primary-400">
                    Filtrar
                </button>
            </div>
        </div>
    </div>
</template>
