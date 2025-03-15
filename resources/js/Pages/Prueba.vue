<script setup>
import { ref } from 'vue';

defineProps({
    message: String,
})

const my_contador = ref(0);

const increment = () => {
    my_contador.value++;
};

const decrement = () => {
    my_contador.value--;
};
</script>

<template>
<div>
    <p>Esta es una prueba de vue con un contador.</p>
    <button @click="increment">Incrementar</button>
    <button @click="decrement">Decrementar</button>
    <p>Contador: {{ my_contador }}</p>
    <p>{{ message }}</p>
</div>
</template>
