<script setup>
import { NConfigProvider } from 'naive-ui';

const themeOverrides = {
  common: {
    primaryColor: '#325d88', // e.g., emerald green
    primaryColorHover: '#5b7da0',
    primaryColorPressed: '#5b7da0',
    primaryColorSuppl: '#5b7da0',
  }
}
</script>

<template>
    <div>
        <NConfigProvider :theme-overrides="themeOverrides">
            <slot></slot>
        </NConfigProvider>
    </div>
</template>
