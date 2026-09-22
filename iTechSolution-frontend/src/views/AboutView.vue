<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { getAboutContent } from '@/services/content.service'
import type { AboutContent } from '@/types/content'

const content = ref<AboutContent | null>(null)

onMounted(async () => {
  content.value = await getAboutContent()
})
</script>

<template>
  <div v-if="content">
    <section class="page-hero">
      <div class="container">
        <span class="breadcrumb">Trang chủ / <strong>Giới thiệu</strong></span>
        <h1 class="section-title">{{ content.heroTitle }}</h1>
        <p v-if="content.heroSubtitle" class="section-subtitle">{{ content.heroSubtitle }}</p>
      </div>
    </section>

    <section class="section story">
      <div class="container story__grid">
        <img v-if="content.storyImage" :src="content.storyImage" alt="" class="story__media story__media--img" />
        <div v-else class="story__media" aria-hidden="true">
          <i class="pi pi-image" />
          <span>Ảnh văn phòng / đội ngũ</span>
        </div>
        <div class="story__content">
          <h2 class="section-title">Câu chuyện của chúng tôi</h2>
          <p v-for="(paragraph, index) in content.storyParagraphs" :key="index">{{ paragraph }}</p>
        </div>
      </div>
    </section>

    <section class="section section--muted">
      <div class="container vm-grid">
        <div class="vm-card">
          <div class="vm-card__icon"><i class="pi pi-eye" /></div>
          <h3>Tầm nhìn</h3>
          <p>{{ content.vision }}</p>
        </div>
        <div class="vm-card">
          <div class="vm-card__icon"><i class="pi pi-flag" /></div>
          <h3>Sứ mệnh</h3>
          <p>{{ content.mission }}</p>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <h2 class="section-title section-title--center">Giá trị cốt lõi</h2>
        <div class="values-grid">
          <div v-for="value in content.values" :key="value.title" class="value-card">
            <i :class="['pi', value.icon]" />
            <div class="value-card__title">{{ value.title }}</div>
            <p class="value-card__desc">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section section--muted">
      <div class="container stats-grid">
        <div v-for="stat in content.stats" :key="stat.label" class="stat-card">
          <div class="stat-card__value">{{ stat.value }}</div>
          <div class="stat-card__label">{{ stat.label }}</div>
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
  max-width: 720px;
}

.page-hero .section-subtitle {
  margin: 0;
  max-width: 640px;
}

.story__grid {
  display: flex;
  align-items: center;
  gap: 64px;
}

.story__media {
  flex: 1;
  height: 320px;
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

.story__media--img {
  border: none;
  object-fit: cover;
  width: 100%;
}

.story__content {
  flex: 1;
}

.story__content p {
  color: var(--p-text-muted-color);
  line-height: 1.7;
}

.section--muted {
  background: var(--p-content-hover-background);
}

.vm-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 24px;
}

.vm-card {
  background: var(--p-content-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 32px;
}

.vm-card__icon {
  width: 44px;
  height: 44px;
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;
}

.vm-card__icon .pi {
  font-size: 20px;
  color: var(--p-primary-600);
}

.vm-card h3 {
  margin: 0 0 8px;
  font-size: 18px;
}

.vm-card p {
  margin: 0;
  color: var(--p-text-muted-color);
  line-height: 1.6;
}

.section-title--center {
  text-align: center;
  margin-bottom: 40px;
}

.values-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 24px;
}

.value-card {
  text-align: center;
}

.value-card .pi {
  font-size: 28px;
  color: var(--p-primary-600);
}

.value-card__title {
  font-weight: 600;
  font-size: 15px;
  margin: 12px 0 6px;
}

.value-card__desc {
  font-size: 13px;
  color: var(--p-text-muted-color);
  line-height: 1.5;
  margin: 0;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 24px;
  text-align: center;
}

.stat-card__value {
  font-size: 32px;
  font-weight: 700;
  color: var(--p-primary-600);
}

.stat-card__label {
  font-size: 13px;
  color: var(--p-text-muted-color);
}

@media (max-width: 900px) {
  .story__grid {
    flex-direction: column;
  }

  .vm-grid,
  .values-grid,
  .stats-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
</style>
