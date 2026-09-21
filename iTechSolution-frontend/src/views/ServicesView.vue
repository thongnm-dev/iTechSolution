<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Button from 'primevue/button'
import { getServices } from '@/services/content.service'
import type { Service } from '@/types/content'

const services = ref<Service[]>([])

onMounted(async () => {
  services.value = await getServices()
})
</script>

<template>
  <div>
    <section class="page-hero">
      <div class="container">
        <span class="breadcrumb">Trang chủ / <strong>Dịch vụ</strong></span>
        <h1 class="section-title">Dịch vụ của chúng tôi</h1>
        <p class="section-subtitle">
          [Mô tả ngắn về nhóm dịch vụ công nghệ mà công ty cung cấp cho khách hàng doanh nghiệp]
        </p>
      </div>
    </section>

    <section class="section">
      <div class="container services-grid">
        <div v-for="service in services" :key="service.title" class="service-card">
          <div class="service-card__icon">
            <i :class="['pi', service.icon]" />
          </div>
          <div class="service-card__title">{{ service.title }}</div>
          <p class="service-card__desc">{{ service.description }}</p>
        </div>
      </div>
    </section>

    <section class="cta">
      <div class="container cta__inner">
        <h2>[Bạn cần tư vấn giải pháp phù hợp?]</h2>
        <p>[Liên hệ với chúng tôi để được tư vấn miễn phí về dịch vụ phù hợp với doanh nghiệp bạn]</p>
        <RouterLink to="/contact">
          <Button label="Liên hệ ngay" size="large" severity="contrast" />
        </RouterLink>
      </div>
    </section>
  </div>
</template>

<style scoped>
.page-hero {
  background: var(--p-content-hover-background);
  padding: 48px 0;
  border-bottom: 1px solid var(--p-content-border-color);
}

.breadcrumb {
  font-size: 13px;
  color: var(--p-text-muted-color);
}

.page-hero .section-title {
  margin: 16px 0 12px;
}

.page-hero .section-subtitle {
  margin: 0;
  max-width: 640px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 24px;
}

.service-card {
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 28px;
}

.service-card__icon {
  width: 44px;
  height: 44px;
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;
}

.service-card__icon .pi {
  font-size: 20px;
  color: var(--p-primary-600);
}

.service-card__title {
  font-weight: 600;
  font-size: 16px;
  margin-bottom: 8px;
}

.service-card__desc {
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
  margin: 0;
}

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
  font-size: 26px;
}

.cta__inner p {
  margin: 0 0 12px;
  color: var(--p-surface-300);
  max-width: 480px;
}

@media (max-width: 900px) {
  .services-grid {
    grid-template-columns: 1fr;
  }
}
</style>
