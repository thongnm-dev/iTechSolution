<script setup lang="ts">
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const stats = [
  { value: '10+', labelKey: 'years' },
  { value: '50+', labelKey: 'projects' },
  { value: '30+', labelKey: 'clients' },
] as const
</script>

<template>
  <section class="section">
    <div class="container about">
      <div class="about__media" aria-hidden="true">
        <i class="pi pi-image" />
        <span>[Ảnh văn phòng / đội ngũ]</span>
      </div>
      <div class="about__content">
        <h2 class="section-title">{{ t('home.about.title') }}</h2>
        <p class="about__description">{{ t('home.about.description') }}</p>
        <div class="about__stats">
          <div v-for="stat in stats" :key="stat.labelKey" class="about__stat">
            <div class="about__stat-value">{{ stat.value }}</div>
            <div class="about__stat-label">{{ t(`home.about.stats.${stat.labelKey}`) }}</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.about {
  display: flex;
  align-items: center;
  gap: 64px;
}

.about__media {
  flex: 1;
  height: 280px;
  border: 1px dashed var(--p-surface-300);
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--p-text-muted-color);
  font-size: 13px;
}

.about__content {
  flex: 1;
}

.about__description {
  color: var(--p-text-muted-color);
  line-height: 1.7;
  margin: 0 0 24px;
}

.about__stats {
  display: flex;
  gap: 16px;
}

.about__stat {
  flex: 1;
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 16px;
  text-align: center;
}

.about__stat-value {
  font-size: 22px;
  font-weight: 700;
  color: var(--p-primary-600);
}

.about__stat-label {
  font-size: 12px;
  color: var(--p-text-muted-color);
}

@media (max-width: 900px) {
  .about {
    flex-direction: column;
  }
}
</style>
