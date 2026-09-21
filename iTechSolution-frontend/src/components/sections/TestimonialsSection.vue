<script setup lang="ts">
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const testimonials = [1, 2, 3]
</script>

<template>
  <section class="section section--muted">
    <div class="container">
      <h2 class="section-title section-title--center">{{ t('home.testimonials.title') }}</h2>
      <div class="testimonials-grid">
        <div v-for="item in testimonials" :key="item" class="testimonial-card">
          <p>"[Trích dẫn nhận xét của khách hàng {{ item }}]"</p>
          <div class="testimonial-card__author">
            <div class="testimonial-card__avatar" aria-hidden="true" />
            <div>
              <div class="testimonial-card__name">[Tên khách hàng]</div>
              <div class="testimonial-card__role">[Chức danh / công ty]</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.section--muted {
  background: var(--p-content-hover-background);
}

.section-title--center {
  text-align: center;
  margin-bottom: 40px;
}

.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 24px;
}

.testimonial-card {
  background: var(--p-content-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.testimonial-card p {
  margin: 0;
  font-size: 13px;
  color: var(--p-text-color);
  line-height: 1.6;
}

.testimonial-card__author {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: auto;
}

.testimonial-card__avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--p-content-border-color);
  flex-shrink: 0;
}

.testimonial-card__name {
  font-size: 13px;
  font-weight: 600;
}

.testimonial-card__role {
  font-size: 11px;
  color: var(--p-text-muted-color);
}

@media (max-width: 900px) {
  .testimonials-grid {
    grid-template-columns: 1fr;
  }
}
</style>
