<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import Skeleton from 'primevue/skeleton'
import { useSeo } from '@/composables/useSeo'
import { getServices } from '@/services/content.service'
import type { Service } from '@/types/content'

const { t } = useI18n()

useSeo({ title: t('nav.services'), description: t('services.heroSubtitle') })

const processSteps = [
  { icon: 'pi-comments', color: '#6366f1', bg: 'rgba(99,102,241,0.12)' },
  { icon: 'pi-pencil', color: '#f59e0b', bg: 'rgba(245,158,11,0.12)' },
  { icon: 'pi-code', color: '#10b981', bg: 'rgba(16,185,129,0.12)' },
  { icon: 'pi-check-circle', color: '#f43f5e', bg: 'rgba(244,63,94,0.12)' },
]

const services = ref<Service[]>([])
const loading = ref(true)

onMounted(async () => {
  services.value = await getServices()
  loading.value = false
})
</script>

<template>
  <div>
    <!-- Hero -->
    <section class="svc-hero">
      <div class="svc-hero__blob svc-hero__blob--1" aria-hidden="true" />
      <div class="svc-hero__blob svc-hero__blob--2" aria-hidden="true" />
      <div class="container svc-hero__inner">
        <span v-reveal class="breadcrumb">{{ t('nav.home') }} / <strong>{{ t('services.breadcrumb') }}</strong></span>
        <h1 v-reveal="60">{{ t('services.heroTitle') }}</h1>
        <p v-reveal="120" class="svc-hero__subtitle">{{ t('services.heroSubtitle') }}</p>
      </div>
    </section>

    <!-- Services Grid -->
    <section class="section">
      <div class="container">
        <div v-if="loading" class="services-grid">
          <div v-for="i in 4" :key="i" class="skeleton-card">
            <Skeleton height="220px" border-radius="20px 20px 0 0" />
            <div class="skeleton-card__body">
              <Skeleton width="60%" height="18px" />
              <Skeleton width="100%" height="14px" />
              <Skeleton width="80%" height="14px" />
            </div>
          </div>
        </div>
        <div v-else class="services-grid">
          <div
            v-for="(service, index) in services"
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
              <p class="service-card__desc">{{ service.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Process -->
    <section class="section section--muted">
      <div class="container">
        <h2 v-reveal class="section-title section-title--center">{{ t('services.processTitle') }}</h2>
        <p v-reveal="60" class="section-subtitle section-subtitle--center">{{ t('services.processSubtitle') }}</p>

        <div class="process-wave">
          <svg class="process-wave__svg" viewBox="0 0 1200 320" preserveAspectRatio="none" fill="none" aria-hidden="true">
            <defs>
              <linearGradient id="wave-grad" x1="0" y1="0" x2="1200" y2="0" gradientUnits="userSpaceOnUse">
                <stop offset="0%" stop-color="#818cf8" />
                <stop offset="100%" stop-color="#fbbf24" />
              </linearGradient>
            </defs>
            <path
              d="M 150,230 C 275,230 325,90 450,90 C 575,90 625,230 750,230 C 875,230 925,90 1050,90"
              stroke="url(#wave-grad)"
              stroke-width="3"
              stroke-dasharray="14 10"
              stroke-linecap="round"
            />
          </svg>

          <div class="process-wave__steps">
            <div
              v-for="(step, i) in processSteps"
              :key="i"
              v-reveal="i * 150"
              class="process-wave__step"
              :class="i % 2 === 0 ? 'process-wave__step--low' : 'process-wave__step--high'"
              :style="{ '--step-color': step.color, '--step-bg': step.bg }"
            >
              <div v-if="i % 2 === 1" class="process-wave__info">
                <span class="process-wave__word">Step</span>
                <span class="process-wave__num">{{ String(i + 1).padStart(2, '0') }}</span>
                <div class="process-wave__title">{{ t(`services.steps[${i}].title`) }}</div>
              </div>

              <div class="process-wave__pin">
                <div class="process-wave__pin-inner">
                  <i :class="['pi', step.icon]" />
                </div>
              </div>

              <div v-if="i % 2 === 0" class="process-wave__info">
                <span class="process-wave__num">{{ String(i + 1).padStart(2, '0') }}</span>
                <span class="process-wave__word">Step</span>
                <div class="process-wave__title">{{ t(`services.steps[${i}].title`) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="svc-cta">
      <div class="svc-cta__blob" aria-hidden="true" />
      <div v-reveal class="container svc-cta__inner">
        <h2>{{ t('services.ctaTitle') }}</h2>
        <p>{{ t('services.ctaSubtitle') }}</p>
        <RouterLink to="/contact" class="svc-cta__btn">
          {{ t('services.ctaButton') }} &rarr;
        </RouterLink>
      </div>
    </section>
  </div>
</template>

<style scoped>
/* ── Hero ────────────────────────────────── */
.svc-hero {
  position: relative;
  background: linear-gradient(160deg, rgba(30, 27, 75, 0.95), rgba(79, 70, 229, 0.85));
  padding: 72px 0 88px;
  overflow: hidden;
  color: #fff;
}

.svc-hero__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.2;
  pointer-events: none;
}

.svc-hero__blob--1 {
  width: 400px;
  height: 400px;
  background: var(--accent-400);
  top: -120px;
  right: -60px;
}

.svc-hero__blob--2 {
  width: 300px;
  height: 300px;
  background: var(--p-primary-300);
  bottom: -80px;
  left: -40px;
}

.svc-hero__inner {
  position: relative;
  z-index: 1;
  max-width: 680px;
}

.svc-hero .breadcrumb {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.6);
}

.svc-hero .breadcrumb strong {
  color: rgba(255, 255, 255, 0.9);
}

.svc-hero h1 {
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 800;
  line-height: 1.15;
  margin: 20px 0 16px;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.svc-hero__subtitle {
  font-size: 17px;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin: 0;
  max-width: 560px;
}

/* ── Services Grid ───────────────────────── */
.services-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  grid-auto-rows: 1fr;
  gap: 28px;
}

.service-card {
  display: flex;
  border: 1px solid var(--p-content-border-color);
  border-radius: 20px;
  overflow: hidden;
  background: var(--p-content-background);
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
  position: relative;
  height: 100%;
}

.service-card::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 20px;
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
  box-shadow: 0 20px 48px rgba(79, 70, 229, 0.12);
  border-color: transparent;
}

.service-card:hover::before {
  opacity: 1;
  animation: border-rotate 3s linear infinite;
}

.service-card__media {
  width: 220px;
  min-height: 220px;
  flex-shrink: 0;
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
  transform: scale(1.06);
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
  padding: 28px 28px 28px 24px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  flex: 1;
}

.service-card__title {
  font-weight: 700;
  font-size: 18px;
  margin-bottom: 10px;
}

.service-card__desc {
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.7;
  margin: 0;
}

/* ── Process Wave ────────────────────────── */
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
  margin: 0 auto 56px;
  color: var(--p-text-muted-color);
  line-height: 1.7;
}

.process-wave {
  position: relative;
  height: 320px;
}

.process-wave__svg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.process-wave__steps {
  position: relative;
  display: flex;
  height: 100%;
  z-index: 1;
}

.process-wave__step {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
}

.process-wave__step--low {
  justify-content: flex-end;
  padding-bottom: 12px;
}

.process-wave__step--high {
  justify-content: flex-start;
  padding-top: 12px;
}

.process-wave__pin {
  position: relative;
  width: 76px;
  height: 76px;
  border-radius: 50%;
  border: 4px solid var(--step-color);
  background: var(--p-content-background);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.process-wave__step:hover .process-wave__pin {
  transform: scale(1.08);
  box-shadow: 0 8px 28px var(--step-bg);
}

.process-wave__pin::after {
  content: '';
  position: absolute;
  bottom: -14px;
  left: 50%;
  transform: translateX(-50%);
  border-left: 11px solid transparent;
  border-right: 11px solid transparent;
  border-top: 16px solid var(--step-color);
}

.process-wave__pin-inner {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: var(--step-color);
  display: flex;
  align-items: center;
  justify-content: center;
}

.process-wave__pin-inner .pi {
  font-size: 22px;
  color: #fff;
}

.process-wave__info {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.process-wave__word {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: var(--p-primary-400);
  line-height: 1;
}

.process-wave__num {
  font-size: 34px;
  font-weight: 800;
  color: var(--step-color);
  line-height: 1.1;
}

.process-wave__title {
  font-weight: 700;
  font-size: 14px;
  max-width: 150px;
  line-height: 1.45;
  margin-top: 4px;
}

/* ── CTA ─────────────────────────────────── */
.svc-cta {
  background: linear-gradient(135deg, var(--p-primary-900), var(--p-primary-700));
  color: #fff;
  padding: 72px 0;
  position: relative;
  overflow: hidden;
}

.svc-cta__blob {
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

.svc-cta__inner {
  position: relative;
  z-index: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.svc-cta__inner h2 {
  margin: 0;
  font-size: clamp(24px, 3vw, 30px);
  font-weight: 800;
}

.svc-cta__inner p {
  margin: 0 0 8px;
  color: var(--p-primary-200);
  font-size: 16px;
  max-width: 480px;
  line-height: 1.6;
}

.svc-cta__btn {
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

.svc-cta__btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  color: var(--p-primary-800);
  text-decoration: none;
}

/* ── Skeleton ───────────────────────────── */
.skeleton-card {
  border-radius: 20px;
  border: 1px solid var(--p-content-border-color);
  background: var(--p-content-background);
  overflow: hidden;
}

.skeleton-card__body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .services-grid {
    grid-template-columns: 1fr;
  }

  .service-card {
    flex-direction: column;
  }

  .service-card__media {
    width: 100%;
    height: 200px;
    min-height: auto;
  }

  .process-wave {
    height: auto;
  }

  .process-wave__svg {
    display: none;
  }

  .process-wave__steps {
    flex-direction: column;
    align-items: center;
    gap: 36px;
    height: auto;
  }

  .process-wave__step {
    max-width: 280px;
    width: 100%;
  }

  .process-wave__step--low,
  .process-wave__step--high {
    justify-content: center;
    padding: 0;
  }

  .process-wave__step--high {
    flex-direction: column-reverse;
  }
}
</style>
