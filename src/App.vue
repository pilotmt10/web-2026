<script setup lang="ts">
  import DefaultLayout from "@/layouts/DefaultLayout.vue";
</script>

<template>
  <component :is="$route.meta.layout || DefaultLayout">
    <slot />
  </component>
</template>