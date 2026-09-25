<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { getServices } from '@/services/content.service'
import type { Service } from '@/types/content'

const { t } = useI18n()

const featuredServices = ref<Service[]>([])

onMounted(async () => {
  const services = await getServices()
  featuredServices.value = services.slice(0, 4)
})
</script>

<template>
  <section id="services" class="section section--services">
    <div class="container">
      <div v-reveal class="section-header">
        <h2 class="section-title">{{ t('home.services.title') }}</h2>
        <p class="section-subtitle">{{ t('home.services.subtitle') }}</p>
      </div>
      <div class="services-grid">
        <div
          v-for="(service, index) in featuredServices"
          :key="service.title"
          v-reveal="index * 100"
          class="service-card"
        >
          <div class="service-card__media">
            <img
              v-if="service.image"
              :src="service.image"
              :alt="service.title"
              class="service-card__img"
              loading="lazy"
            />
            <div v-else class="service-card__icon-wrap">
              <i :class="['pi', service.icon]" />
            </div>
          </div>
          <div class="service-card__body">
            <div class="service-card__title">{{ service.title }}</div>
            <div class="service-card__desc">{{ service.description }}</div>
          </div>
        </div>
      </div>
      <div v-reveal="500" class="services-link">
        <RouterLink to="/services">{{ t('home.services.title') }} &rarr;</RouterLink>
      </div>
    </div>
  </section>
</template>

<style scoped>
.section--services {
  background: var(--p-content-background);
}

.section-header {
  text-align: center;
}

.section-header .section-subtitle {
  margin: 0 auto 48px;
  max-width: 520px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 24px;
}

.service-card {
  background: var(--p-content-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 16px;
  overflow: hidden;
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
  position: relative;
}

.service-card::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 16px;
  padding: 1px;
  background: conic-gradient(from var(--border-angle), var(--p-primary-400), var(--accent-400), var(--p-primary-300), var(--accent-400), var(--p-primary-400));
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask-composite: xor;
  opacity: 0;
  transition: opacity 0.35s ease;
  pointer-events: none;
}

.service-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 40px rgba(79, 70, 229, 0.12);
  border-color: transparent;
}

.service-card:hover::before {
  opacity: 1;
  animation: border-rotate 3s linear infinite;
}

.service-card__media {
  height: 180px;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.service-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}

.service-card:hover .service-card__img {
  transform: scale(1.05);
}

.service-card__icon-wrap {
  width: 64px;
  height: 64px;
  border-radius: 16px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  display: flex;
  align-items: center;
  justify-content: center;
}

.service-card__icon-wrap .pi {
  font-size: 26px;
  color: #fff;
}

.service-card__body {
  padding: 20px 24px 24px;
}

.service-card__title {
  font-weight: 700;
  font-size: 16px;
  margin-bottom: 8px;
}

.service-card__desc {
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
}

.services-link {
  text-align: center;
  margin-top: 40px;
}

.services-link a {
  font-weight: 600;
  font-size: 15px;
  transition: gap 0.2s ease;
}

@media (max-width: 900px) {
  .services-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 500px) {
  .services-grid {
    grid-template-columns: 1fr;
  }
}
</style>
