<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'

const { t } = useI18n()
</script>

<template>
  <section id="cta" class="cta">
    <div class="cta__blob cta__blob--1" aria-hidden="true" />
    <div class="cta__blob cta__blob--2" aria-hidden="true" />
    <div v-reveal class="container cta__inner">
      <h2>{{ t('home.cta.title') }}</h2>
      <p>{{ t('home.cta.subtitle') }}</p>
      <RouterLink to="/contact">
        <Button :label="t('home.cta.button')" size="large" severity="contrast" raised />
      </RouterLink>
    </div>
  </section>
</template>

<style scoped>
.cta {
  background: linear-gradient(135deg, var(--p-primary-900) 0%, var(--p-primary-700) 50%, var(--p-primary-800) 100%);
  color: #fff;
  padding: 80px 0;
  position: relative;
  overflow: hidden;
}

.cta__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.15;
  pointer-events: none;
}

.cta__blob--1 {
  width: 400px;
  height: 400px;
  background: var(--accent-400);
  top: -100px;
  right: -50px;
}

.cta__blob--2 {
  width: 300px;
  height: 300px;
  background: var(--p-primary-300);
  bottom: -80px;
  left: -40px;
}

.cta__inner {
  position: relative;
  z-index: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.cta__inner h2 {
  margin: 0;
  font-size: clamp(24px, 3vw, 32px);
  font-weight: 800;
}

.cta__inner p {
  margin: 0 0 12px;
  color: var(--p-primary-200);
  font-size: 16px;
  max-width: 480px;
  line-height: 1.6;
}
</style>
