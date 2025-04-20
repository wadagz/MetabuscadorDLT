<script setup>
import { ref, watch, onBeforeUnmount, onMounted } from 'vue';
import Fuse from 'fuse.js';
import { NButton, NCheckbox, NInput, NInputNumber, NSelect } from 'naive-ui';
import { formatCurrency, parseCurrency } from '../../../Utils/priceFormatter';
import { Icon } from '@iconify/vue/dist/iconify.js';

const props = defineProps({
    amenidades: Object,
});

const emit = defineEmits(['filterChange']);

// Refs para el listado de amenidades
const showAmenidades = ref(false);
const amenidadesSearchQuery = ref('');
const amenidadesToShow = ref(props.amenidades);
const amenidadesSeleccionadas = ref([]);

// Ref para cerrar dorpdown menu al hacer click fuere de este
const dropdownRef = ref(null)

// Ref para rango de precios
const priceRange = ref({
    min: null,
    max: null,
});

// Ref para seleccion de orden
const selectedSortOptions = ref([]);

// Config de fuse para fuzzy search.
const fuse = new Fuse(props.amenidades, {
    keys: ['nombre', 'descripcion'],
    includeScore: true,
    threshold: 0.4, // lower = stricter
});

// Base filter and sort for cleaning the filters
const baseFilters = {
    precio: { $between: null },
    amenidades: {
        id: {
            $in: amenidadesSeleccionadas,
        },
    },
};

// Filters structure compatible with Laravel Purity
const filters = ref({
    ...baseFilters
});

// Ordenamiento por columna y dirección
const sort = ref(null);

// Aplica los filtros seleccionados
function applyFilters() {
    // Si se seteó un max o min para precio agrega el rango a los filtros.
    if (priceRange.value.min || priceRange.value.max) {
        filters.value.precio.$between = [
            priceRange.value.min ? priceRange.value.min : 0,
            priceRange.value.max ? priceRange.value.max : 100000,
        ]
    }

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

    if (selectedSortOptions.value.length > 0) {
        sort.value = [
            ...selectedSortOptions.value
        ];
    }

    console.log(selectedSortOptions)
    console.log('sort.value berofe emit', sort.value)

    // Emite la señal para que el componente padre haga fetch con los nuevos filtros.
    emit('filterChange', {
        filters: cleanFilters,
        sort: sort.value ? sort.value : null
    });
};

// Setea los filtros a su estado inicial
const cleanFilters = () => {
    sort.value = null;
    selectedSortOptions.value = []
    amenidadesSeleccionadas.value = [];
    filters.value.precio.$between = null;
    priceRange.value = { min: null, max: null }
    applyFilters();
}

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
        type: "group",
        label: "Nombre",
        key: "Nombre",
        children: [
            {
                label: 'A a Z',
                value: 'nombre:asc'
            },
            {
                label: 'Z a A',
                value: 'nombre:desc'
            }
        ],

    },
    {
        type: "group",
        label: "Precio",
        key: "Precio",
        children: [
            {
                label: "Menor a mayor",
                value: 'precio:asc'
            },
            {
                label: "Mayor a menor",
                value: 'precio:desc'
            }
        ]
    }
];

// Lógica para seleccionar máximo una opción por grupo en select Orden
const sortValuesGroupMap = {}
sortOptions.forEach(group => {
    group.children.forEach(option => {
        sortValuesGroupMap[option.value] = group.key
    })
})

// Permite que solo un elemento de cada grupo sea seleccionado a la vez.
const handleSelectSort = (newValues, otro) => {
    // Si se han deseleccionado todods los valores
    if (newValues.length === 0) {
        selectedSortOptions.value = [];
        sort.value = null;
        return
    }

    const latest = newValues[newValues.length - 1]
    const groupOfLatest = sortValuesGroupMap[latest]

    // Keep only the latest from that group, and others from different groups
    selectedSortOptions.value = [
        ...newValues.filter(value => {
            return (
                value === latest || sortValuesGroupMap[value] !== groupOfLatest
            )
        }),
    ]
}

</script>

<template>
<div class="max-w-xl xl:max-w-7xl mx-auto rounded-sm ">
    <!-- <div class="grid grid-cols-5 gap-2"> -->
    <div class="flex flex-row justify-evenly gap-2">

        <!-- Selección de ordenamiento -->
        <div class="flex-grow grid grid-rows-2 items-center">
            <label class="">Ordenar por</label>
            <NSelect
                v-model:value="selectedSortOptions"
                multiple
                clearable
                :options="sortOptions"
                @update:value="handleSelectSort"
                placeholder="Orden"
            />
        </div>

        <!-- Selección de rango de precio -->
        <div class="flex-shrink grid grid-rows-2 items-center">
            <label class="">Rango de precios</label>
            <div class="flex items-center">
                <NInputNumber
                    v-model:value="priceRange.min"
                    placeholder="Mínimo"
                    :validator="(x) => priceRange.max ? x <= priceRange.max : true"
                    :parse="parseCurrency"
                    :format="formatCurrency"
                    :min="0"
                    :max="100000"
                    :step="1000"
                >
                    <template #prefix>
                        <Icon icon="material-symbols-light:attach-money-rounded" />
                    </template>
                </NInputNumber>
                <NInputNumber
                    v-model:value="priceRange.max"
                    placeholder="Máximo"
                    :validator="(x) => priceRange.min ? x >= priceRange.min : true"
                    :parse="parseCurrency"
                    :format="formatCurrency"
                    :min="0"
                    :max="100000"
                    :step="1000"
                >
                    <template #prefix>
                        <Icon icon="material-symbols-light:attach-money-rounded" />
                    </template>
                </NInputNumber>
            </div>
        </div>

        <!-- Selección de amenidades -->
        <div class="flex-shrink grid grid-rows-2 items-center justify-center">
            <label class="">Amenidades</label>

            <div class="relative inline-block text-left" ref="dropdownRef">
                <div>
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
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex flex-shrink text-center items-end justify-end gap-2">
            <NButton
                attr-type="button"
                type="primary"
                strong
                @click="applyFilters"
            >
                <template #icon>
                    <Icon icon="mdi:filter-check" />
                </template>
                Filtrar
            </NButton>
            <NButton
                secondary
                attr-type="button"
                strong
                @click="cleanFilters"
            >
                <template #icon>
                    <Icon icon="mdi:filter-off" />
                </template>
                Limpiar filtros
            </NButton>
        </div>
    </div>
</div>
</template>
