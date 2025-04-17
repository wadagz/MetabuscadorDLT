<script setup>
import { Icon } from '@iconify/vue/dist/iconify.js';
const emit = defineEmits(["close"]);

function closeModal() {
  emit("close");
};

</script>

<template>
<Teleport to="body">
    <div class="modal">
        <div class="modal-content rounded-md p-4" @click.stop>
            <div class="title text-2xl flex flex-row justify-between items-center" v-if="$slots.title">
                <slot name="title" />
                <button type="button" @click="emit('close')">
                    <Icon icon="material-symbols-light:close" />
                </button>
            </div>

            <hr class="my-2 border border-gray-200">

            <slot name="body" />
        </div>
    </div>
</Teleport>
</template>

<style lang="css" scoped>
.modal {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;

    z-index: 99999;
    background-color: rgba(143, 143, 143, 0.65);

    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    flex-basis: 600px;
    padding: spacing(4);

    background-color: white;
    border-radius: 5;
}

.title {
  /* font-size: $font-size-3; */
  font-weight: 700;
  margin-bottom: spacing(2);
}

.close {
  position: absolute;
  top: spacing(3);
  right: spacing(3);
}
</style>
