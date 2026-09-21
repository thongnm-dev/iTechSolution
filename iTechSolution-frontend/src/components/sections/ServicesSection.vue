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
  <section class="section section--muted">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">{{ t('home.services.title') }}</h2>
        <p class="section-subtitle">{{ t('home.services.subtitle') }}</p>
        <RouterLink to="/services">Xem tất cả dịch vụ &gt;</RouterLink>
      </div>
      <div class="services-grid">
        <div v-for="service in featuredServices" :key="service.title" class="service-card">
          <i :class="['pi', service.icon]" />
          <div class="service-card__title">{{ service.title }}</div>
          <div class="service-card__desc">{{ service.description }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.section--muted {
  background: var(--p-content-hover-background);
}

.section-header {
  text-align: center;
}

.section-header .section-subtitle {
  margin: 0 auto 40px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 24px;
}

.service-card {
  background: var(--p-content-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 24px;
}

.service-card .pi {
  font-size: 24px;
  color: var(--p-primary-600);
}

.service-card__title {
  font-weight: 600;
  font-size: 15px;
  margin: 12px 0 6px;
}

.service-card__desc {
  font-size: 13px;
  color: var(--p-text-muted-color);
  line-height: 1.5;
}

@media (max-width: 900px) {
  .services-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
</style>
