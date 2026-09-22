<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'

const { t } = useI18n()
</script>

<template>
  <section class="hero">
    <div class="container hero__inner">
      <div v-reveal class="hero__copy">
        <h1>{{ t('home.hero.title') }}</h1>
        <p>{{ t('home.hero.subtitle') }}</p>
        <div class="hero__actions">
          <RouterLink to="/contact">
            <Button :label="t('home.hero.ctaPrimary')" size="large" />
          </RouterLink>
          <RouterLink to="/services">
            <Button :label="t('home.hero.ctaSecondary')" size="large" severity="secondary" outlined />
          </RouterLink>
        </div>
      </div>
      <div v-reveal="150" class="hero__media" aria-hidden="true">
        <i class="pi pi-image" />
        <span>[Hình / video minh hoạ]</span>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  background: var(--p-content-hover-background);
  padding: 80px 0;
}

.hero__inner {
  display: flex;
  align-items: center;
  gap: 64px;
}

.hero__copy {
  flex: 1;
}

.hero__copy h1 {
  font-size: 42px;
  line-height: 1.25;
  margin: 0 0 16px;
}

.hero__copy p {
  font-size: 16px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
  max-width: 460px;
  margin: 0 0 28px;
}

.hero__actions {
  display: flex;
  gap: 16px;
}

.hero__media {
  flex: 1;
  height: 360px;
  border: 1px dashed var(--p-surface-300);
  border-radius: 8px;
  background: var(--p-content-background);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--p-text-muted-color);
  font-size: 13px;
}

.hero__media .pi {
  font-size: 32px;
}

@media (max-width: 900px) {
  .hero__inner {
    flex-direction: column;
  }
}
</style>
