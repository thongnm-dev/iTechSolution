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
      <div v-reveal class="about__media">
        <img
          class="about__img"
          src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=900&q=70"
          alt="Đội ngũ iTechSolution làm việc cùng nhau"
          loading="lazy"
        />
      </div>
      <div v-reveal="150" class="about__content">
        <h2 class="section-title">{{ t('home.about.title') }}</h2>
        <p class="about__description">{{ t('home.about.description') }}</p>
        <div class="about__stats">
          <div
            v-for="(stat, index) in stats"
            :key="stat.labelKey"
            v-reveal="250 + index * 100"
            class="about__stat"
          >
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
  border-radius: 8px;
  overflow: hidden;
  background: var(--p-content-hover-background);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

.about__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
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
