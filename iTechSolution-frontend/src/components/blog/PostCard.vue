<script setup lang="ts">
import type { Post } from '@/types/blog'

defineProps<{ post: Post }>()
</script>

<template>
  <RouterLink :to="`/blog/${post.slug}`" class="post-card">
    <img v-if="post.coverImage" :src="post.coverImage" :alt="post.title" class="post-card__media post-card__media--img" />
    <div v-else class="post-card__media" aria-hidden="true">
      <i class="pi pi-image" />
    </div>
    <span class="post-card__meta">{{ post.category.name }} · {{ new Date(post.publishedAt).toLocaleDateString() }}</span>
    <div class="post-card__title">{{ post.title }}</div>
    <p class="post-card__excerpt">{{ post.excerpt }}</p>
  </RouterLink>
</template>

<style scoped>
.post-card {
  display: flex;
  flex-direction: column;
  gap: 10px;
  color: inherit;
  text-decoration: none;
}

.post-card:hover .post-card__title {
  color: var(--p-primary-600);
}

.post-card__media {
  height: 150px;
  border: 1px dashed var(--p-surface-300);
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-text-muted-color);
  font-size: 22px;
}

.post-card__media--img {
  border: none;
  object-fit: cover;
  width: 100%;
}

.post-card__meta {
  font-size: 11px;
  color: var(--p-text-muted-color);
}

.post-card__title {
  font-weight: 600;
  font-size: 15px;
  line-height: 1.4;
}

.post-card__excerpt {
  margin: 0;
  font-size: 13px;
  color: var(--p-text-muted-color);
  line-height: 1.5;
}
</style>
