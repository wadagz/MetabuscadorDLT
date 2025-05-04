<script setup>
import { getWeekDayFromNumber } from '@/Utils/dateFormatter.js';

const props = defineProps({
    horarios: Array,
})
</script>

<template>
<table class="table-auto w-full border border-gray-300">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 text-left">Dia de semana</th>
        <th class="px-4 py-2 text-left">Hora inicio</th>
        <th class="px-4 py-2 text-left">Hora fin</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="horario in horarios" :key="horario.id" class="border-t">
        <td class="px-4 py-2">{{ getWeekDayFromNumber(horario.dia_semana) }}</td>
        <td class="px-4 py-2">{{ horario.hora_inicio.slice(0,5) }}</td>
        <td class="px-4 py-2">{{ horario.hora_fin.slice(0,5) }}</td>
      </tr>
      <tr v-if="horarios.length === 0">
        <td colspan="4" class="text-center py-4 text-gray-500">No hay registros</td>
      </tr>
    </tbody>
  </table>
</template>
