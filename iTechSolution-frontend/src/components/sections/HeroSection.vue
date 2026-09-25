<script setup lang="ts">
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
</script>

<template>
  <section id="hero" class="hero">
    <video
      class="hero__bg-video"
      autoplay
      muted
      loop
      playsinline
      preload="metadata"
      poster="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=70"
    >
      <source
        src="https://videos.pexels.com/video-files/3141210/3141210-hd_1920_1080_25fps.mp4"
        type="video/mp4"
      />
    </video>
    <div class="hero__overlay" />
    <div class="hero__blob hero__blob--1" aria-hidden="true" />
    <div class="hero__blob hero__blob--2" aria-hidden="true" />

    <div class="container hero__inner">
      <div v-reveal class="hero__badge">UI/UX & Software Engineering</div>
      <h1 v-reveal="80" class="hero__title">{{ t('home.hero.title') }}</h1>
      <p v-reveal="160" class="hero__subtitle">{{ t('home.hero.subtitle') }}</p>
      <div v-reveal="240" class="hero__actions">
        <RouterLink to="/contact" class="hero__btn-primary">
          {{ t('home.hero.ctaPrimary') }}
        </RouterLink>
        <RouterLink to="/services" class="hero__btn-outline">
          {{ t('home.hero.ctaSecondary') }}
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  position: relative;
  min-height: calc(100vh - var(--header-height));
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.hero__bg-video {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    160deg,
    rgba(30, 27, 75, 0.92) 0%,
    rgba(79, 70, 229, 0.78) 50%,
    rgba(99, 102, 241, 0.7) 100%
  );
}

.dark .hero__overlay {
  background: linear-gradient(
    160deg,
    rgba(3, 7, 18, 0.94) 0%,
    rgba(30, 27, 75, 0.88) 50%,
    rgba(49, 46, 129, 0.82) 100%
  );
}

.hero__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.3;
  pointer-events: none;
}

.hero__blob--1 {
  width: 500px;
  height: 500px;
  background: var(--accent-400);
  top: -120px;
  right: -80px;
  animation: float-blob 18s ease-in-out infinite;
}

.hero__blob--2 {
  width: 400px;
  height: 400px;
  background: var(--p-primary-400);
  bottom: -100px;
  left: -60px;
  animation: float-blob 22s ease-in-out infinite reverse;
}

@keyframes float-blob {
  0%, 100% { transform: translate(0, 0) scale(1); }
  33% { transform: translate(30px, -20px) scale(1.05); }
  66% { transform: translate(-20px, 15px) scale(0.95); }
}

.hero__inner {
  position: relative;
  z-index: 1;
  text-align: center;
  padding: 80px 24px;
  max-width: 800px;
}

.hero__badge {
  display: inline-block;
  padding: 6px 20px;
  border-radius: 100px;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0.5px;
  color: var(--accent-400);
  border: 1px solid rgba(251, 191, 36, 0.3);
  background: rgba(251, 191, 36, 0.08);
  margin-bottom: 24px;
}

.hero__title {
  font-size: clamp(36px, 5vw, 56px);
  font-weight: 800;
  line-height: 1.15;
  margin: 0 0 20px;
  color: #fff;
  background: linear-gradient(90deg, #fff 0%, var(--accent-400) 25%, #fff 50%, var(--p-primary-200) 75%, #fff 100%);
  background-size: 200% 100%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: title-shimmer 4s ease-in-out infinite;
}

@keyframes title-shimmer {
  0% { background-position: 100% 50%; }
  100% { background-position: -100% 50%; }
}

.hero__subtitle {
  font-size: clamp(16px, 2vw, 19px);
  color: rgba(255, 255, 255, 0.92);
  line-height: 1.7;
  max-width: 560px;
  margin: 0 auto 36px;
}

.hero__actions {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
}

.hero__btn-primary,
.hero__btn-outline {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 12px 28px;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
  z-index: 0;
}

.hero__btn-primary::before,
.hero__btn-outline::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 10px;
  padding: 2px;
  background: conic-gradient(from var(--border-angle), var(--accent-400), #fff, var(--p-primary-300), var(--accent-400));
  mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask-composite: xor;
  animation: border-rotate 3s linear infinite;
  pointer-events: none;
  z-index: -1;
}

.hero__btn-primary::after,
.hero__btn-outline::after {
  content: '';
  position: absolute;
  inset: 2px;
  border-radius: 8px;
  pointer-events: none;
  z-index: -1;
}

.hero__btn-primary {
  color: var(--p-primary-700);
}

.hero__btn-primary::after {
  background: #fff;
}

.hero__btn-primary:hover {
  color: var(--p-primary-800);
  text-decoration: none;
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
}

.hero__btn-primary:hover::after {
  background: #f0f0ff;
}

.hero__btn-outline {
  color: #fff;
}

.hero__btn-outline::after {
  background: rgba(255, 255, 255, 0.1);
}

.hero__btn-outline:hover {
  color: #fff;
  text-decoration: none;
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

.hero__btn-outline:hover::after {
  background: rgba(255, 255, 255, 0.2);
}

@media (max-width: 600px) {
  .hero__inner {
    padding: 60px 16px;
  }

  .hero__actions {
    flex-direction: column;
    align-items: center;
  }
}
</style>
