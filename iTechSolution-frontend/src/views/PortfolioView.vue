<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { getProjects } from '@/services/content.service'
import type { Project } from '@/types/content'

const projects = ref<Project[]>([])

onMounted(async () => {
  projects.value = await getProjects()
})
</script>

<template>
  <div>
    <section class="page-hero">
      <div class="container">
        <span class="breadcrumb">Trang chủ / <strong>Dự án</strong></span>
        <h1 class="section-title">Dự án nổi bật</h1>
        <p class="section-subtitle">
          Những dự án tiêu biểu chúng tôi đã triển khai cho khách hàng ở nhiều lĩnh vực —
          từ thương mại điện tử, y tế đến quản trị doanh nghiệp.
        </p>
      </div>
    </section>

    <section class="section">
      <div class="container portfolio-grid">
        <div v-for="project in projects" :key="project.title" class="portfolio-card">
          <img v-if="project.image" :src="project.image" :alt="project.title" class="portfolio-card__media portfolio-card__media--img" />
          <div v-else class="portfolio-card__media" aria-hidden="true">
            <i class="pi pi-image" />
            <span>Ảnh dự án</span>
          </div>
          <span class="portfolio-card__category">{{ project.category }}</span>
          <div class="portfolio-card__title">{{ project.title }}</div>
          <p class="portfolio-card__desc">{{ project.description }}</p>
        </div>
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

.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.portfolio-card {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.portfolio-card__media {
  height: 180px;
  border: 1px dashed var(--p-surface-300);
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
  color: var(--p-text-muted-color);
  font-size: 24px;
}

.portfolio-card__media--img {
  border: none;
  object-fit: cover;
  width: 100%;
}

.portfolio-card__media span {
  font-size: 12px;
}

.portfolio-card__category {
  font-size: 11px;
  color: var(--p-text-muted-color);
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

.portfolio-card__title {
  font-weight: 600;
  font-size: 16px;
}

.portfolio-card__desc {
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
  margin: 0;
}

@media (max-width: 900px) {
  .portfolio-grid {
    grid-template-columns: 1fr;
  }
}
</style>
