<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'

const { t } = useI18n()
</script>

<template>
  <section class="cta">
    <div class="container cta__inner">
      <h2>{{ t('home.cta.title') }}</h2>
      <p>{{ t('home.cta.subtitle') }}</p>
      <RouterLink to="/contact">
        <Button :label="t('home.cta.button')" size="large" severity="contrast" />
      </RouterLink>
    </div>
  </section>
</template>

<style scoped>
.cta {
  background: var(--p-surface-900);
  color: #fff;
  padding: 64px 0;
}

.cta__inner {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.cta__inner h2 {
  margin: 0;
  font-size: 28px;
}

.cta__inner p {
  margin: 0 0 12px;
  color: var(--p-surface-300);
}
</style>
