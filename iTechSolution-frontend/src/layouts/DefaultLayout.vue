<script setup lang="ts">
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
</script>

<template>
  <AppHeader />
  <main class="app-main">
    <slot />
  </main>
  <AppFooter />
</template>

<style scoped>
.app-main {
  flex: 1;
}
</style>
