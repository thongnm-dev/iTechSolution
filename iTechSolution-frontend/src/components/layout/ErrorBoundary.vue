<script setup lang="ts">
import { ref, onErrorCaptured } from 'vue'
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'

const { t } = useI18n()
const error = ref<Error | null>(null)

onErrorCaptured((err) => {
  error.value = err
  return false
})

function retry() {
  error.value = null
}
</script>

<template>
  <div v-if="error" class="error-boundary">
    <div class="error-boundary__inner">
      <i class="pi pi-exclamation-triangle error-boundary__icon" />
      <h2 class="error-boundary__title">{{ t('error.title') }}</h2>
      <p class="error-boundary__desc">{{ t('error.description') }}</p>
      <Button :label="t('error.retry')" icon="pi pi-refresh" @click="retry" raised />
    </div>
  </div>
  <slot v-else />
</template>

<style scoped>
.error-boundary {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 400px;
  padding: 40px 24px;
}

.error-boundary__inner {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  max-width: 420px;
}

.error-boundary__icon {
  font-size: 48px;
  color: var(--p-primary-400);
  opacity: 0.6;
}

.error-boundary__title {
  margin: 0;
  font-size: 20px;
  font-weight: 700;
}

.error-boundary__desc {
  margin: 0;
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
}
</style>
