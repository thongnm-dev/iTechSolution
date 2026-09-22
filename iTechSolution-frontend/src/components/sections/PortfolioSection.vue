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
        <RouterLink to="/portfolio">{{ t('home.portfolio.viewAll') }} &gt;</RouterLink>
      </div>
      <div class="portfolio-grid">
        <div
          v-for="(project, index) in featuredProjects"
          :key="project.title"
          v-reveal="index * 100"
          class="portfolio-card"
        >
          <img v-if="project.image" :src="project.image" :alt="project.title" class="portfolio-card__media portfolio-card__media--img" />
          <div v-else class="portfolio-card__media" aria-hidden="true">
            <i class="pi pi-image" />
          </div>
          <span class="portfolio-card__category">{{ project.category }}</span>
          <div class="portfolio-card__title">{{ project.title }}</div>
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
  margin-bottom: 40px;
}

.section-header--row .section-title {
  margin: 0;
}

.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 24px;
}

.portfolio-card {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.portfolio-card__media {
  height: 200px;
  border: 1px dashed var(--p-surface-300);
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-text-muted-color);
  font-size: 28px;
}

.portfolio-card__media--img {
  border: none;
  object-fit: cover;
  width: 100%;
}

.portfolio-card__category {
  font-size: 11px;
  color: var(--p-text-muted-color);
}

.portfolio-card__title {
  font-weight: 600;
  font-size: 15px;
}

@media (max-width: 900px) {
  .portfolio-grid {
    grid-template-columns: 1fr;
  }
}
</style>
