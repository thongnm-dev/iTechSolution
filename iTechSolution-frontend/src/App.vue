<script setup lang="ts">
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import ErrorBoundary from '@/components/layout/ErrorBoundary.vue'
</script>

<template>
  <DefaultLayout>
    <ErrorBoundary>
      <RouterView v-slot="{ Component }">
        <Transition name="page" mode="out-in">
          <component :is="Component" />
        </Transition>
      </RouterView>
    </ErrorBoundary>
  </DefaultLayout>
</template>

<style>
.page-enter-active,
.page-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(12px);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(-12px);
}
</style>
