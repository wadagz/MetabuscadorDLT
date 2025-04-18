<script setup>
import { ref, inject } from 'vue';
import { Icon } from '@iconify/vue/dist/iconify.js';

const props = defineProps({
    amenidades: Array,
});

const emit = defineEmits(['filterChange']);

// Filters structure compatible with Laravel Purity
const filters = ref({
    precio: { $lte: 5000 },
});

const sort = ref({
    field: 'nombre',
    direction: 'asc'
});

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

  emit('filterChange', {
    filters: cleanFilters,
    sort: sort.value.field ? sort.value : null
  });
}
</script>

<template>
    <div class="mt-4 bg-light max-w-xl xl:max-w-7xl mx-auto rounded-md border border-gray-400">
        <div class="flex flex-nowrap items-center justify-evenly">
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Ordenar</label>
                <Icon icon="material-symbols:sort" />
                <select v-model="sort.direction" name="destino" class="w-11/12 rounded-md mb-2 mt-1 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option value="asc">A a la Z</option>
                    <option value="desc">Z a la A</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Precio</label>
                <Icon icon="mdi:cash" />
                <select v-model="filters.precio.$lte"  name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option value="5000">Hasta $5,000</option>
                    <option value="10000">Hasta $10,000</option>
                    <option value="20000">Hasta  $20,000</option>
                </select>
            </div>
            <div class="flex-grow text-center grid grid-col-4 items-center">
                <label class="col-start-1 col-span-4 mt-1">Amenidades</label>
                <Icon icon="mdi:home-plus" />
                <select name="destino" class="w-11/12 rounded-md mb-2 mt-1 py-2 col-start-2 col-span-3" placeholder="E.j. Puerto Vallarta">
                    <option></option>
                    <option v-for="amenidad in amenidades" :key="amenidad" :value="amenidad">
                        {{ amenidad }}
                    </option>
                </select>
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
