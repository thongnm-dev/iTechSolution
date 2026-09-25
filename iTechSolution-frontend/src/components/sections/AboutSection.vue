<script setup lang="ts">
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const stats = [
  { value: '10+', labelKey: 'years', icon: 'pi-calendar' },
  { value: '50+', labelKey: 'projects', icon: 'pi-briefcase' },
  { value: '30+', labelKey: 'clients', icon: 'pi-users' },
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
          <div
            v-for="(stat, index) in stats"
            :key="stat.labelKey"
            v-reveal="250 + index * 100"
            class="about__stat"
          >
            <i :class="['pi', stat.icon, 'about__stat-icon']" />
            <div class="about__stat-value">{{ stat.value }}</div>
            <div class="about__stat-label">{{ t(`home.about.stats.${stat.labelKey}`) }}</div>
          </div>
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

.about__stat {
  flex: 1;
  border: 1px solid var(--p-content-border-color);
  border-radius: 16px;
  padding: 20px 16px;
  text-align: center;
  background: var(--p-content-background);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.about__stat:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(79, 70, 229, 0.1);
}

.about__stat-icon {
  font-size: 20px;
  color: var(--p-primary-500);
  margin-bottom: 8px;
  display: block;
}

.about__stat-value {
  font-size: 28px;
  font-weight: 800;
  background: linear-gradient(135deg, var(--p-primary-600), var(--accent-500));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.about__stat-label {
  font-size: 12px;
  color: var(--p-text-muted-color);
  margin-top: 4px;
  font-weight: 500;
}

@media (max-width: 900px) {
  .about {
    flex-direction: column;
    gap: 48px;
  }
}
</style>
