<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'
import { useSeo } from '@/composables/useSeo'

const { t } = useI18n()

useSeo({ title: t('notFound.title'), description: t('notFound.description') })
</script>

<template>
  <section class="not-found">
    <div class="not-found__blob not-found__blob--1" aria-hidden="true" />
    <div class="not-found__blob not-found__blob--2" aria-hidden="true" />
    <div class="container not-found__inner">
      <span class="not-found__code">404</span>
      <h1 class="not-found__title">{{ t('notFound.title') }}</h1>
      <p class="not-found__desc">{{ t('notFound.description') }}</p>
      <RouterLink to="/">
        <Button :label="t('notFound.backHome')" icon="pi pi-arrow-left" raised />
      </RouterLink>
    </div>
  </section>
</template>

<style scoped>
.not-found {
  position: relative;
  min-height: calc(100vh - var(--header-height, 64px) - 200px);
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(160deg, rgba(30, 27, 75, 0.95), rgba(79, 70, 229, 0.85));
  overflow: hidden;
  color: #fff;
  padding: 80px 0;
}

.not-found__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.2;
  pointer-events: none;
}

.not-found__blob--1 {
  width: 500px;
  height: 500px;
  background: var(--accent-400);
  top: -160px;
  right: -80px;
}

.not-found__blob--2 {
  width: 400px;
  height: 400px;
  background: var(--p-primary-300);
  bottom: -120px;
  left: -60px;
}

.not-found__inner {
  position: relative;
  z-index: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.not-found__code {
  font-size: clamp(100px, 20vw, 180px);
  font-weight: 900;
  line-height: 1;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 30%, rgba(255, 255, 255, 0.05) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  user-select: none;
}

.not-found__title {
  font-size: clamp(24px, 4vw, 36px);
  font-weight: 800;
  margin: 0;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.not-found__desc {
  font-size: 17px;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin: 0;
  max-width: 480px;
}
</style>
