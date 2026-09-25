<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useSeo } from '@/composables/useSeo'
import { getServices } from '@/services/content.service'
import type { Service } from '@/types/content'

const { t } = useI18n()

useSeo({ title: t('nav.services'), description: t('services.heroSubtitle') })

const processSteps = [
  { icon: 'pi-comments' },
  { icon: 'pi-pencil' },
  { icon: 'pi-code' },
  { icon: 'pi-check-circle' },
]

const services = ref<Service[]>([])

onMounted(async () => {
  services.value = await getServices()
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
        <div class="services-grid">
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
        <div class="process-grid">
          <div v-for="(step, i) in processSteps" :key="i" v-reveal="i * 120" class="process-step">
            <div class="process-step__number">{{ String(i + 1).padStart(2, '0') }}</div>
            <div class="process-step__icon-wrap">
              <i :class="['pi', step.icon]" />
            </div>
            <div class="process-step__title">{{ t(`services.steps[${i}].title`) }}</div>
            <p class="process-step__desc">{{ t(`services.steps[${i}].desc`) }}</p>
            <div v-if="i < 3" class="process-step__connector" aria-hidden="true" />
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

/* ── Process ─────────────────────────────── */
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

.process-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 24px;
}

.process-step {
  text-align: center;
  position: relative;
  padding: 0 8px;
}

.process-step__number {
  font-size: 13px;
  font-weight: 800;
  color: var(--p-primary-400);
  letter-spacing: 1px;
  margin-bottom: 16px;
  opacity: 0.6;
}

.process-step__icon-wrap {
  width: 64px;
  height: 64px;
  border-radius: 18px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  transition: transform 0.3s ease;
}

.process-step:hover .process-step__icon-wrap {
  transform: scale(1.1);
}

.process-step__icon-wrap .pi {
  font-size: 24px;
  color: #fff;
}

.process-step__title {
  font-weight: 700;
  font-size: 15px;
  margin-bottom: 8px;
}

.process-step__desc {
  font-size: 13px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
  margin: 0;
}

.process-step__connector {
  position: absolute;
  top: 62px;
  right: -16px;
  width: 32px;
  height: 2px;
  background: linear-gradient(90deg, var(--p-primary-400), var(--accent-400));
  opacity: 0.4;
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

  .process-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 32px;
  }

  .process-step__connector {
    display: none;
  }
}

@media (max-width: 500px) {
  .process-grid {
    grid-template-columns: 1fr;
  }
}
</style>
