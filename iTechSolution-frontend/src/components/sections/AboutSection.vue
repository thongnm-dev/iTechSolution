<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import StatCounter from './StatCounter.vue'

const { t } = useI18n()

const stats = [
  { target: 10, suffix: '+', labelKey: 'years', icon: 'pi-calendar' },
  { target: 50, suffix: '+', labelKey: 'projects', icon: 'pi-briefcase' },
  { target: 30, suffix: '+', labelKey: 'clients', icon: 'pi-users' },
] as const
</script>

<template>
  <section class="section section--about">
    <div class="container about">
      <div v-reveal class="about__media-wrap">
        <div class="about__accent" aria-hidden="true" />
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
          <StatCounter
            v-for="(stat, index) in stats"
            :key="stat.labelKey"
            v-reveal="250 + index * 100"
            :target="stat.target"
            :suffix="stat.suffix"
            :icon="stat.icon"
            :label="t(`home.about.stats.${stat.labelKey}`)"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.section--about {
  background: var(--p-content-hover-background);
}

.about {
  display: flex;
  align-items: center;
  gap: 72px;
}

.about__media-wrap {
  flex: 1;
  position: relative;
}

.about__accent {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 16px;
  left: -16px;
  border-radius: 20px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--accent-400));
  opacity: 0.15;
}

.about__img {
  position: relative;
  width: 100%;
  height: 320px;
  border-radius: 20px;
  object-fit: cover;
  display: block;
  box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
}

.about__content {
  flex: 1;
}

.about__description {
  color: var(--p-text-muted-color);
  line-height: 1.8;
  margin: 0 0 32px;
  font-size: 15px;
}

.about__stats {
  display: flex;
  gap: 16px;
}

@media (max-width: 900px) {
  .about {
    flex-direction: column;
    gap: 48px;
  }
}
</style>
