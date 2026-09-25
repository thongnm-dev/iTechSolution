<script setup lang="ts">
import type { Post } from '@/types/blog'

defineProps<{ post: Post }>()
</script>

<template>
  <RouterLink :to="`/blog/${post.slug}`" class="post-card">
    <div class="post-card__media-wrap">
      <img v-if="post.coverImage" :src="post.coverImage" :alt="post.title" class="post-card__media post-card__media--img" />
      <div v-else class="post-card__media" aria-hidden="true">
        <i class="pi pi-image" />
      </div>
    </div>
    <div class="post-card__body">
      <span class="post-card__meta">{{ post.category.name }} · {{ new Date(post.publishedAt).toLocaleDateString() }}</span>
      <div class="post-card__title">{{ post.title }}</div>
      <p class="post-card__excerpt">{{ post.excerpt }}</p>
      <span class="post-card__read-more">Đọc thêm &rarr;</span>
    </div>
  </RouterLink>
</template>

<style scoped>
.post-card {
  display: flex;
  flex-direction: column;
  color: inherit;
  text-decoration: none;
  border-radius: 20px;
  overflow: hidden;
  border: 1px solid var(--p-content-border-color);
  background: var(--p-content-background);
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
  position: relative;
}

.post-card::before {
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

.post-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(79, 70, 229, 0.12);
  border-color: transparent;
  text-decoration: none;
}

.post-card:hover::before {
  opacity: 1;
}

.post-card__media-wrap {
  overflow: hidden;
  height: 200px;
}

.post-card__media {
  height: 100%;
  width: 100%;
  border: none;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-text-muted-color);
  font-size: 28px;
}

.post-card__media--img {
  object-fit: cover;
  display: block;
  transition: transform 0.6s ease;
}

.post-card:hover .post-card__media--img {
  transform: scale(1.08);
}

.post-card__body {
  padding: 20px 24px 24px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex: 1;
}

.post-card__meta {
  font-size: 12px;
  font-weight: 500;
  color: var(--p-primary-500);
  letter-spacing: 0.3px;
}

.post-card__title {
  font-weight: 700;
  font-size: 17px;
  line-height: 1.4;
  transition: color 0.2s ease;
}

.post-card:hover .post-card__title {
  color: var(--p-primary-600);
}

.post-card__excerpt {
  margin: 0;
  font-size: 14px;
  color: var(--p-text-muted-color);
  line-height: 1.6;
  flex: 1;
}

.post-card__read-more {
  font-size: 13px;
  font-weight: 600;
  color: var(--p-primary-500);
  transition: color 0.2s ease;
}

.post-card:hover .post-card__read-more {
  color: var(--p-primary-700);
}
</style>
