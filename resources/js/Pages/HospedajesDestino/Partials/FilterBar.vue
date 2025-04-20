<script setup>
import { ref, inject, watch, onBeforeUnmount, onMounted } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';
import Fuse from 'fuse.js';
import { NButton, NCheckbox, NInput, NSelect } from 'naive-ui';

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
}, 100)

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

const sortOptions = [
    {
        label: 'A a Z',
        value: 'asc',
    },
    {
        label: 'Z a A',
        value: 'desc',
    },
];

const precioOptions = [
    {
        label: 'Hasta $5,000',
        value: '5000',
    },
    {
        label: 'Hasta $10,000',
        value: '10000',
    },
    {
        label: 'Hasta $15,000',
        value: '15000',
    },
    {
        label: 'Hasta $20,000',
        value: '20000',
    },
];

const personasOptions = [
    {
        label: '1',
        value: '1',
    },
    {
        label: '2',
        value: '2',
    },
    {
        label: '3',
        value: '3',
    },
    {
        label: '4',
        value: '4',
    },
];

// Pruebas de uso de NSelect para amenidades
const amenidadOptions = Object.entries(props.amenidades).map(([idx, amenidad]) => ({
    label: amenidad.nombre,
    value: amenidad.id,
    description: amenidad.descripcion
}));

const fusible = new Fuse(amenidadOptions, {
    keys: ['label', 'description'],
    threshold: 0.4,
})

const selectedValue = ref(null)
const searchQuery = ref('')
const filteredOptions = ref([...amenidadOptions]) // Start with full list

const handleSearch = (pattern) => {
  searchQuery.value = pattern

  if (!pattern) {
    filteredOptions.value = [...amenidadOptions]
  } else {
    const results = fusible.search(pattern).map(result => result.item)
    filteredOptions.value = results
  }
}

const renderCustomTag = ({ option }) => {
  return h('span', { class: 'text-red-500' }, option.label)
}
// Fin de pruebas de uso NSelect para amenidades


// const rolOptions = Object.entries(RolLabels).map(([value, label]) => ({
//     label,
//     value
// }));
</script>

<template>
    <div class="mt-4 bg-light max-w-xl xl:max-w-7xl mx-auto rounded-sm border border-gray-400">
        <div class="grid grid-cols-5 items-center justify-evenly gap-2">

            <!-- Selección de ordenamiento -->
            <div class="grid grid-rows-2 items-center">
                <label class="">Ordenar</label>
                <!-- <Icon icon="material-symbols:sort" /> -->
                <!-- <select v-model="sort.direction" name="destino" class="w-11/12 rounded-sm mb-2 mt-1 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option value="asc">A a la Z</option>
                    <option value="desc">Z a la A</option>
                </select> -->
                <NSelect
                    v-model:value="sort.direction"
                    :options="sortOptions"
                />
            </div>

            <!-- Selección de rango de precio -->
            <div class="grid grid-rows-2 items-center">
                <label class="">Precio</label>
                <!-- <Icon icon="mdi:cash" /> -->
                <!-- <select v-model="filters.precio.$lte"  name="destino" class="w-11/12 rounded-sm mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option value="5000">Hasta $5,000</option>
                    <option value="10000">Hasta $10,000</option>
                    <option value="20000">Hasta  $20,000</option>
                </select> -->
                <NSelect
                    v-model:value="filters.precio.$lte"
                    :options="precioOptions"
                />
            </div>

            <!-- <div class="grid grid-rows-2 items-center">
                <label class="">Precio</label>
                <NSelect
                    multiple
                    filterable
                    :filter="() => true"
                    clearable
                    :options="filteredOptions"
                    :max-tag-count="1"
                    @search="handleSearch"
                    placeholder="Amenidades"
                    :label-field="'label'"
                    :value-field="'value'"
                    :render-tag="renderCustomTag"
                />
            </div> -->

            <!-- Selección de amenidades -->
            <div class="grid grid-rows-2 items-center justify-center">
                <label class="">Precio</label>

                <div class="relative inline-block text-left" ref="dropdownRef">
                    <div>
                        <!-- <button
                            type="button"
                            @click="showAmenidades = !showAmenidades"
                            class="rounded-sm bg-cyan-700 text-white px-2 py-1"
                        >
                            Seleccionar Amenidades
                        </button> -->
                        <NButton
                            type="default"
                            secondary
                            attr-type="button"
                            @click="showAmenidades = !showAmenidades"
                        >
                            Seleccionar Amenidades
                        </NButton>
                    </div>

                    <!-- Dropdown menu para seleccionar amenidades -->
                    <Transition
                        enter-active-class="transition duration-200 ease-out"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-80"
                    >
                        <div
                            v-if="showAmenidades"
                            class="origin-top-right mt-2 w-96 rounded-sm shadow-lg bg-white ring-1
                                ring-black ring-opacity-5 focus:outline-none z-[9999]
                                absolute top-10 p-2
                            "
                        >
                            <!-- Input para buscar amenidades en concreto -->
                            <div>
                                <!-- <input
                                    v-model="amenidadesSearchQuery"
                                    class="max-h-6 w-full"
                                > -->
                                <NInput
                                    v-model:value="amenidadesSearchQuery"
                                    type="text"
                                    placeholder="Amenidad"
                                    clearable
                                />
                            </div>

                            <hr>

                            <!-- Lista de amenidades -->
                            <div class="overflow-y-auto" style="max-height: 20rem">
                                <div v-for="amenidad in amenidadesToShow" :key="amenidad.id" class="transition duration-75 hover:bg-gray-100">
                                    <div class="flex items-center pl-1 py-2 ">
                                        <NCheckbox
                                            :checked="amenidadesSeleccionadas.indexOf(amenidad.id) !== -1"
                                            @click="handleAmenidadCheckBox(amenidad.id)"
                                        >
                                            {{ amenidad.nombre }}
                                        </NCheckbox>
                                        <!-- <input
                                        @click="handleAmenidadCheckBox(amenidad.id)"
                                        type="checkbox"
                                        :id="amenidad.nombre"
                                        :checked="amenidadesSeleccionadas.indexOf(amenidad.id) !== -1"
                                        /> -->
                                        <!-- <label :for="amenidad.nombre" class="ml-2 w-full">
                                            {{ amenidad.nombre }}
                                        </label> -->
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>


            <div class="grid grid-rows-2 items-center">
                <label class="">Cant. Personas</label>
                <NSelect
                    :options="personasOptions"
                />
                <!-- <select name="destino" class="w-11/12 rounded-sm mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select> -->
            </div>

            <div>
                <div class="flex flex-row text-center gap-2">
                    <NButton
                        attr-type="button"
                        type="primary"
                        strong
                        @click="applyFilters"
                    >
                        Filtrar
                    </NButton>
                    <NButton
                        attr-type="button"
                        type="secondary"
                        strong
                    >
                        Limpiar filtros
                    </NButton>
                    <!-- <button @click="applyFilters" type="button" class="rounded-sm bg-primary-500 w-11/12 py-1 mr-2 mt-6 text-white transition duration-300 hover:bg-primary-400">
                        Filtrar
                    </button> -->
                    <!-- <button type="button" class="rounded-sm bg-secondary w-11/12 py-1 mr-2 mt-6 text-white transition duration-300 hover:bg-stone-400">
                        Limpiar filtros
                    </button> -->
                </div>
            </div>
        </div>
    </div>
</template>
