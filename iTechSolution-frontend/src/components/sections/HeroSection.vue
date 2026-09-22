<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'

const { t } = useI18n()
</script>

<template>
  <section class="hero">
    <div class="container hero__inner">
      <div v-reveal class="hero__copy">
        <h1>{{ t('home.hero.title') }}</h1>
        <p>{{ t('home.hero.subtitle') }}</p>
        <div class="hero__actions">
          <RouterLink to="/contact">
            <Button :label="t('home.hero.ctaPrimary')" size="large" />
          </RouterLink>
          <RouterLink to="/services">
            <Button :label="t('home.hero.ctaSecondary')" size="large" severity="secondary" outlined />
          </RouterLink>
        </div>
      </div>
      <div v-reveal="150" class="hero__media" aria-hidden="true">
        <video
          class="hero__video"
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
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  background: var(--p-content-hover-background);
  padding: 80px 0;
}

.hero__inner {
  display: flex;
  align-items: center;
  gap: 64px;
}

.hero__copy {
  flex: 1;
}

.hero__copy h1 {
  font-size: 42px;
  line-height: 1.25;
  margin: 0 0 16px;
}

.hero__copy p {
  font-size: 16px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
  max-width: 460px;
  margin: 0 0 28px;
}

.hero__actions {
  display: flex;
  gap: 16px;
}

.hero__media {
  flex: 1;
  height: 360px;
  border-radius: 8px;
  overflow: hidden;
  background: var(--p-content-background);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
}

.hero__video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

@media (max-width: 900px) {
  .hero__inner {
    flex-direction: column;
  }
}
</style>
