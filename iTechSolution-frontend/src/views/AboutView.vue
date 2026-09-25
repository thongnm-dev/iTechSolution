<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { getAboutContent } from '@/services/content.service'
import type { AboutContent } from '@/types/content'
import StatCounter from '@/components/sections/StatCounter.vue'

const content = ref<AboutContent | null>(null)

function parseStatNumber(value: string): { target: number; suffix: string } {
  const match = value.match(/^(\d+)(.*)$/)
  if (!match) return { target: 0, suffix: value }
  return { target: parseInt(match[1], 10), suffix: match[2] }
}

onMounted(async () => {
  content.value = await getAboutContent()
})
</script>

<template>
  <div v-if="content">
    <!-- Hero -->
    <section class="about-hero">
      <div class="about-hero__blob about-hero__blob--1" aria-hidden="true" />
      <div class="about-hero__blob about-hero__blob--2" aria-hidden="true" />
      <div class="container about-hero__inner">
        <span v-reveal class="breadcrumb">Trang chủ / <strong>Giới thiệu</strong></span>
        <h1 v-reveal="60">{{ content.heroTitle }}</h1>
        <p v-if="content.heroSubtitle" v-reveal="120" class="about-hero__subtitle">{{ content.heroSubtitle }}</p>
      </div>
    </section>

    <!-- Stats Trust Bar -->
    <section class="stats-bar">
      <div class="container stats-bar__grid">
        <StatCounter
          v-for="stat in content.stats"
          :key="stat.label"
          v-reveal="100"
          :target="parseStatNumber(stat.value).target"
          :suffix="parseStatNumber(stat.value).suffix"
          icon=""
          :label="stat.label"
          class="stats-bar__item"
        />
      </div>
    </section>

    <!-- Story -->
    <section class="section">
      <div class="container story">
        <div v-reveal class="story__media-wrap">
          <div class="story__accent" aria-hidden="true" />
          <img
            v-if="content.storyImage"
            :src="content.storyImage"
            alt="Đội ngũ iTechSolution"
            class="story__img"
            loading="lazy"
          />
          <div v-else class="story__placeholder" aria-hidden="true">
            <i class="pi pi-image" />
          </div>
        </div>
        <div v-reveal="150" class="story__content">
          <div class="story__label">Câu chuyện của chúng tôi</div>
          <h2 class="section-title">Đồng hành cùng doanh nghiệp trên hành trình số hóa</h2>
          <p v-for="(paragraph, index) in content.storyParagraphs" :key="index">{{ paragraph }}</p>
        </div>
      </div>
    </section>

    <!-- Vision & Mission -->
    <section class="section section--muted">
      <div class="container">
        <h2 v-reveal class="section-title section-title--center">Tầm nhìn & Sứ mệnh</h2>
        <div class="vm-grid">
          <div v-reveal class="vm-card">
            <div class="vm-card__icon-wrap">
              <i class="pi pi-eye" />
            </div>
            <h3>Tầm nhìn</h3>
            <p>{{ content.vision }}</p>
          </div>
          <div v-reveal="120" class="vm-card">
            <div class="vm-card__icon-wrap">
              <i class="pi pi-flag" />
            </div>
            <h3>Sứ mệnh</h3>
            <p>{{ content.mission }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Core Values -->
    <section class="section">
      <div class="container">
        <h2 v-reveal class="section-title section-title--center">Giá trị cốt lõi</h2>
        <p v-reveal="60" class="section-subtitle section-subtitle--center">Những nguyên tắc định hướng mọi hoạt động của chúng tôi</p>
        <div class="values-grid">
          <div v-for="(value, index) in content.values" :key="value.title" v-reveal="index * 100" class="value-card">
            <div class="value-card__icon-wrap">
              <i :class="['pi', value.icon]" />
            </div>
            <div class="value-card__title">{{ value.title }}</div>
            <p class="value-card__desc">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="about-cta">
      <div class="about-cta__blob about-cta__blob--1" aria-hidden="true" />
      <div v-reveal class="container about-cta__inner">
        <h2>Sẵn sàng bắt đầu dự án tiếp theo?</h2>
        <p>Hãy để iTechSolution đồng hành cùng bạn xây dựng giải pháp công nghệ tối ưu.</p>
        <RouterLink to="/contact" class="about-cta__btn">
          Liên hệ ngay &rarr;
        </RouterLink>
      </div>
    </section>
  </div>
</template>

<style scoped>
/* ── Hero ────────────────────────────────── */
.about-hero {
  position: relative;
  background: linear-gradient(160deg, rgba(30, 27, 75, 0.95), rgba(79, 70, 229, 0.85));
  padding: 72px 0 88px;
  overflow: hidden;
  color: #fff;
}

.about-hero__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.2;
  pointer-events: none;
}

.about-hero__blob--1 {
  width: 400px;
  height: 400px;
  background: var(--accent-400);
  top: -120px;
  right: -60px;
}

.about-hero__blob--2 {
  width: 300px;
  height: 300px;
  background: var(--p-primary-300);
  bottom: -80px;
  left: -40px;
}

.about-hero__inner {
  position: relative;
  z-index: 1;
  max-width: 680px;
}

.about-hero .breadcrumb {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.6);
}

.about-hero .breadcrumb strong {
  color: rgba(255, 255, 255, 0.9);
}

.about-hero h1 {
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 800;
  line-height: 1.15;
  margin: 20px 0 16px;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.about-hero__subtitle {
  font-size: 18px;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.6;
  margin: 0;
  max-width: 520px;
}

/* ── Stats Trust Bar ─────────────────────── */
.stats-bar {
  position: relative;
  margin-top: -44px;
  padding: 0 0 16px;
  z-index: 2;
}

.stats-bar__grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 20px;
}

.stats-bar__item {
  background: var(--p-content-background);
  border-radius: 16px;
  padding: 28px 16px;
  text-align: center;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  border: 1px solid var(--p-content-border-color);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stats-bar__item:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 48px rgba(79, 70, 229, 0.12);
}

/* ── Story ───────────────────────────────── */
.story {
  display: flex;
  align-items: center;
  gap: 72px;
}

.story__media-wrap {
  flex: 1;
  position: relative;
  min-width: 0;
}

.story__accent {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 16px;
  left: -16px;
  border-radius: 20px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--accent-400));
  opacity: 0.15;
}

.story__img {
  position: relative;
  width: 100%;
  height: 360px;
  border-radius: 20px;
  object-fit: cover;
  display: block;
  box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
}

.story__placeholder {
  position: relative;
  width: 100%;
  height: 360px;
  border-radius: 20px;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 40px;
  color: var(--p-text-muted-color);
}

.story__content {
  flex: 1;
  min-width: 0;
}

.story__label {
  font-size: 13px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: var(--p-primary-500);
  margin-bottom: 12px;
}

.story__content .section-title {
  font-size: clamp(22px, 2.5vw, 28px);
  line-height: 1.35;
}

.story__content p {
  color: var(--p-text-muted-color);
  line-height: 1.8;
  font-size: 15px;
}

/* ── Vision & Mission ────────────────────── */
.section--muted {
  background: var(--p-content-hover-background);
}

.section-title--center {
  text-align: center;
  margin-bottom: 16px;
}

.section-subtitle--center {
  text-align: center;
  max-width: 520px;
  margin: 0 auto 48px;
}

.vm-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 28px;
  max-width: 900px;
  margin: 40px auto 0;
}

.vm-card {
  background: var(--p-content-background);
  border-radius: 20px;
  padding: 36px 32px;
  border: 1px solid var(--p-content-border-color);
  border-top: 3px solid transparent;
  border-image: linear-gradient(90deg, var(--p-primary-500), var(--accent-400)) 1;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.vm-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(79, 70, 229, 0.1);
}

.vm-card__icon-wrap {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
}

.vm-card__icon-wrap .pi {
  font-size: 22px;
  color: #fff;
}

.vm-card h3 {
  margin: 0 0 10px;
  font-size: 20px;
  font-weight: 700;
}

.vm-card p {
  margin: 0;
  color: var(--p-text-muted-color);
  line-height: 1.7;
  font-size: 15px;
}

/* ── Core Values ─────────────────────────── */
.values-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.value-card {
  text-align: center;
  padding: 32px 24px;
  border-radius: 20px;
  border: 1px solid var(--p-content-border-color);
  background: var(--p-content-background);
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
  position: relative;
}

.value-card::before {
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
}

.value-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 40px rgba(79, 70, 229, 0.1);
  border-color: transparent;
}

.value-card:hover::before {
  opacity: 1;
}

.value-card__icon-wrap {
  width: 60px;
  height: 60px;
  border-radius: 16px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
}

.value-card__icon-wrap .pi {
  font-size: 24px;
  color: #fff;
}

.value-card__title {
  font-weight: 700;
  font-size: 17px;
  margin-bottom: 8px;
}

.value-card__desc {
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.7;
  margin: 0;
}

/* ── CTA ─────────────────────────────────── */
.about-cta {
  background: linear-gradient(135deg, var(--p-primary-900), var(--p-primary-700));
  color: #fff;
  padding: 72px 0;
  position: relative;
  overflow: hidden;
}

.about-cta__blob--1 {
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

.about-cta__inner {
  position: relative;
  z-index: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.about-cta__inner h2 {
  margin: 0;
  font-size: clamp(24px, 3vw, 30px);
  font-weight: 800;
}

.about-cta__inner p {
  margin: 0 0 8px;
  color: var(--p-primary-200);
  font-size: 16px;
  max-width: 460px;
  line-height: 1.6;
}

.about-cta__btn {
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

.about-cta__btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  color: var(--p-primary-800);
  text-decoration: none;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .story {
    flex-direction: column;
    gap: 48px;
  }

  .stats-bar__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .vm-grid {
    grid-template-columns: 1fr;
  }

  .values-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 500px) {
  .stats-bar__grid {
    grid-template-columns: 1fr;
  }
}
</style>
