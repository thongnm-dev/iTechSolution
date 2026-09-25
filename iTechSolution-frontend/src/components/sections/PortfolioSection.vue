<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { getProjects } from '@/services/content.service'
import type { Project } from '@/types/content'

const { t } = useI18n()

const featuredProjects = ref<Project[]>([])

onMounted(async () => {
  const projects = await getProjects()
  featuredProjects.value = projects.slice(0, 3)
})
</script>

<template>
  <section class="section">
    <div class="container">
      <div v-reveal class="section-header section-header--row">
        <h2 class="section-title">{{ t('home.portfolio.title') }}</h2>
        <RouterLink to="/portfolio" class="section-link">{{ t('home.portfolio.viewAll') }} &rarr;</RouterLink>
      </div>
      <div class="portfolio-grid">
        <div
          v-for="(project, index) in featuredProjects"
          :key="project.title"
          v-reveal="index * 120"
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
              <span class="portfolio-card__category">{{ project.category }}</span>
              <div class="portfolio-card__name">{{ project.title }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.section-header--row {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  margin-bottom: 48px;
}

.section-header--row .section-title {
  margin: 0;
}

.section-link {
  font-weight: 600;
  font-size: 15px;
}

.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.portfolio-card {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.portfolio-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(30, 27, 75, 0.25);
}

.portfolio-card__media {
  position: relative;
  height: 260px;
  background: var(--p-content-hover-background);
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
  color: var(--p-text-muted-color);
  font-size: 32px;
  background: var(--p-content-hover-background);
}

.portfolio-card__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(30, 27, 75, 0.75) 0%, transparent 55%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 24px;
  transition: background 0.4s ease;
}

.portfolio-card:hover .portfolio-card__overlay {
  background: linear-gradient(to top, rgba(30, 27, 75, 0.92) 0%, rgba(30, 27, 75, 0.25) 70%);
}

.portfolio-card__category {
  font-size: 12px;
  font-weight: 600;
  color: var(--accent-400);
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 6px;
  transition: transform 0.4s ease;
}

.portfolio-card__name {
  font-weight: 700;
  font-size: 18px;
  color: #fff;
  transition: transform 0.4s ease;
}

.portfolio-card:hover .portfolio-card__category,
.portfolio-card:hover .portfolio-card__name {
  transform: translateY(-4px);
}

@media (max-width: 900px) {
  .portfolio-grid {
    grid-template-columns: 1fr;
  }
}
</style>
