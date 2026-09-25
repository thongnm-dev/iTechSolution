<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useSeo } from '@/composables/useSeo'
import { getProjects } from '@/services/content.service'
import type { Project } from '@/types/content'

useSeo({ title: 'Dự án', description: 'Những dự án tiêu biểu iTechSolution đã triển khai cho khách hàng ở nhiều lĩnh vực.' })

const projects = ref<Project[]>([])

onMounted(async () => {
  projects.value = await getProjects()
})
</script>

<template>
  <div>
    <!-- Hero -->
    <section class="port-hero">
      <div class="port-hero__blob port-hero__blob--1" aria-hidden="true" />
      <div class="port-hero__blob port-hero__blob--2" aria-hidden="true" />
      <div class="container port-hero__inner">
        <span v-reveal class="breadcrumb">Trang chủ / <strong>Dự án</strong></span>
        <h1 v-reveal="60">Dự án nổi bật</h1>
        <p v-reveal="120" class="port-hero__subtitle">
          Những dự án tiêu biểu chúng tôi đã triển khai cho khách hàng ở nhiều lĩnh vực —
          từ thương mại điện tử, y tế đến quản trị doanh nghiệp.
        </p>
      </div>
    </section>

    <!-- Filter + Grid -->
    <section class="section">
      <div class="container">
        <div class="portfolio-grid">
          <div
            v-for="(project, index) in projects"
            :key="project.title"
            v-reveal="index * 100"
            class="portfolio-card"
          >
            <div class="portfolio-card__media">
              <img
                v-if="project.image"
                :src="project.image"
                :alt="project.title"
                class="portfolio-card__img"
                loading="lazy"
              />
              <div v-else class="portfolio-card__placeholder" aria-hidden="true">
                <i class="pi pi-image" />
              </div>
              <div class="portfolio-card__overlay">
                <span class="portfolio-card__cat">{{ project.category }}</span>
              </div>
            </div>
            <div class="portfolio-card__body">
              <div class="portfolio-card__title">{{ project.title }}</div>
              <p class="portfolio-card__desc">{{ project.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="port-cta">
      <div class="port-cta__blob" aria-hidden="true" />
      <div v-reveal class="container port-cta__inner">
        <h2>Bạn có dự án cần triển khai?</h2>
        <p>Hãy chia sẻ ý tưởng — chúng tôi sẽ biến nó thành sản phẩm thực tế.</p>
        <RouterLink to="/contact" class="port-cta__btn">
          Bắt đầu dự án &rarr;
        </RouterLink>
      </div>
    </section>
  </div>
</template>

<style scoped>
/* ── Hero ────────────────────────────────── */
.port-hero {
  position: relative;
  background: linear-gradient(160deg, rgba(30, 27, 75, 0.95), rgba(79, 70, 229, 0.85));
  padding: 72px 0 88px;
  overflow: hidden;
  color: #fff;
}

.port-hero__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.2;
  pointer-events: none;
}

.port-hero__blob--1 {
  width: 400px;
  height: 400px;
  background: var(--accent-400);
  top: -120px;
  right: -60px;
}

.port-hero__blob--2 {
  width: 300px;
  height: 300px;
  background: var(--p-primary-300);
  bottom: -80px;
  left: -40px;
}

.port-hero__inner {
  position: relative;
  z-index: 1;
  max-width: 680px;
}

.port-hero .breadcrumb {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.6);
}

.port-hero .breadcrumb strong {
  color: rgba(255, 255, 255, 0.9);
}

.port-hero h1 {
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 800;
  line-height: 1.15;
  margin: 20px 0 16px;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.port-hero__subtitle {
  font-size: 17px;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin: 0;
  max-width: 560px;
}

/* ── Portfolio Grid ──────────────────────── */
.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 28px;
}

.portfolio-card {
  border-radius: 20px;
  overflow: hidden;
  border: 1px solid var(--p-content-border-color);
  background: var(--p-content-background);
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
  position: relative;
}

.portfolio-card::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 20px;
  padding: 1px;
  background: linear-gradient(135deg, var(--p-primary-400), var(--accent-400));
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask-composite: xor;
  opacity: 0;
  transition: opacity 0.35s ease;
  pointer-events: none;
  z-index: 1;
}

.portfolio-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(79, 70, 229, 0.12);
  border-color: transparent;
}

.portfolio-card:hover::before {
  opacity: 1;
}

.portfolio-card__media {
  position: relative;
  height: 240px;
  background: var(--p-content-hover-background);
  overflow: hidden;
}

.portfolio-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.6s ease;
}

.portfolio-card:hover .portfolio-card__img {
  transform: scale(1.08);
}

.portfolio-card__placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 36px;
  color: var(--p-text-muted-color);
}

.portfolio-card__overlay {
  position: absolute;
  top: 16px;
  left: 16px;
  z-index: 2;
}

.portfolio-card__cat {
  display: inline-block;
  padding: 5px 14px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 600;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(8px);
  color: #fff;
  letter-spacing: 0.3px;
}

.portfolio-card__body {
  padding: 24px 28px 28px;
}

.portfolio-card__title {
  font-weight: 700;
  font-size: 18px;
  margin-bottom: 8px;
}

.portfolio-card__desc {
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.7;
  margin: 0;
}

/* ── CTA ─────────────────────────────────── */
.port-cta {
  background: linear-gradient(135deg, var(--p-primary-900), var(--p-primary-700));
  color: #fff;
  padding: 72px 0;
  position: relative;
  overflow: hidden;
}

.port-cta__blob {
  position: absolute;
  width: 350px;
  height: 350px;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.15;
  background: var(--accent-400);
  top: -80px;
  right: -40px;
  pointer-events: none;
}

.port-cta__inner {
  position: relative;
  z-index: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.port-cta__inner h2 {
  margin: 0;
  font-size: clamp(24px, 3vw, 30px);
  font-weight: 800;
}

.port-cta__inner p {
  margin: 0 0 8px;
  color: var(--p-primary-200);
  font-size: 16px;
  max-width: 460px;
  line-height: 1.6;
}

.port-cta__btn {
  display: inline-block;
  padding: 12px 32px;
  border-radius: 10px;
  background: #fff;
  color: var(--p-primary-700);
  font-weight: 700;
  font-size: 15px;
  text-decoration: none;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.port-cta__btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  color: var(--p-primary-800);
  text-decoration: none;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .portfolio-grid {
    grid-template-columns: 1fr;
  }
}
</style>
