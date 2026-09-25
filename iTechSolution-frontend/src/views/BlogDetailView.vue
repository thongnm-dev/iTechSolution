<script setup lang="ts">
import { computed, onMounted, ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import DOMPurify from 'dompurify'
import Tag from 'primevue/tag'
import { useSeo } from '@/composables/useSeo'
import { useJsonLd } from '@/composables/useJsonLd'
import ReadingProgress from '@/components/layout/ReadingProgress.vue'
import PostCard from '@/components/blog/PostCard.vue'
import { getPostBySlug, getRelatedPosts } from '@/services/blog.service'
import type { Post } from '@/types/blog'

const props = defineProps<{ slug: string }>()
const { t } = useI18n()

const post = ref<Post | null>(null)
const relatedPosts = ref<Post[]>([])

const postTitle = computed(() => post.value?.title ?? t('blog.defaultTitle'))
useSeo({
  title: postTitle,
  description: computed(() => post.value?.excerpt ?? ''),
  image: computed(() => post.value?.cover_image ?? ''),
  type: 'article',
})

const sanitizedContent = computed(() => (post.value ? DOMPurify.sanitize(post.value.content) : ''))

useJsonLd(computed(() => {
  if (!post.value) return {}
  return {
    '@context': 'https://schema.org',
    '@type': 'BlogPosting',
    headline: post.value.title,
    description: post.value.excerpt,
    image: post.value.coverImage,
    datePublished: post.value.publishedAt,
    author: { '@type': 'Person', name: post.value.author.name },
    publisher: { '@type': 'Organization', name: 'iTechSolution' },
  }
}))

const shareLinks = computed(() => {
  const url = encodeURIComponent(typeof window !== 'undefined' ? window.location.href : '')
  const title = encodeURIComponent(post.value?.title ?? '')
  return [
    { icon: 'pi-facebook', label: 'Facebook', href: `https://www.facebook.com/sharer/sharer.php?u=${url}` },
    { icon: 'pi-twitter', label: 'X', href: `https://twitter.com/intent/tweet?url=${url}&text=${title}` },
    { icon: 'pi-linkedin', label: 'LinkedIn', href: `https://www.linkedin.com/sharing/share-offsite/?url=${url}` },
  ]
})

async function loadPost(slug: string) {
  post.value = (await getPostBySlug(slug)) ?? null
  relatedPosts.value = post.value ? await getRelatedPosts(post.value.slug) : []
}

watch(() => props.slug, loadPost)
onMounted(() => loadPost(props.slug))
</script>

<template>
  <div v-if="post">
    <ReadingProgress />
    <section class="post-header">
      <div class="container">
        <span class="breadcrumb">
          {{ t('nav.home') }} / {{ t('nav.blog') }} / <strong>{{ post.title }}</strong>
        </span>
        <h1>{{ post.title }}</h1>
        <div class="post-header__author">
          <div class="avatar" aria-hidden="true" />
          <span class="post-header__author-name">{{ post.author.name }}</span>
          <span class="post-header__separator">·</span>
          <span class="post-header__date">{{ new Date(post.publishedAt).toLocaleDateString() }}</span>
          <span class="post-header__separator">·</span>
          <span class="post-header__date">{{ post.minutesToRead }} {{ t('blog.minRead') }}</span>
          <div class="post-header__share">
            <a
              v-for="link in shareLinks"
              :key="link.label"
              :href="link.href"
              target="_blank"
              rel="noopener noreferrer"
              :aria-label="`${t('blog.shareLabel')} ${link.label}`"
              class="share-btn"
            >
              <i :class="['pi', link.icon]" />
            </a>
          </div>
        </div>
      </div>
    </section>

    <img v-if="post.coverImage" :src="post.coverImage" :alt="post.title" class="container cover cover--img" />
    <section v-else class="container cover" aria-hidden="true">
      <i class="pi pi-image" />
      <span>{{ t('blog.coverAlt') }}</span>
    </section>

    <section class="container post-body">
      <article class="post-body__content" v-html="sanitizedContent" />
    </section>

    <section class="container post-footer">
      <div class="tags">
        <span>{{ t('blog.tags') }}:</span>
        <Tag v-for="tag in post.tags" :key="tag.id" :value="tag.name" severity="secondary" />
      </div>
      <div class="author-box">
        <div class="avatar avatar--lg" aria-hidden="true" />
        <div>
          <div class="author-box__name">{{ post.author.name }}</div>
          <p>{{ post.author.bio }}</p>
        </div>
      </div>
    </section>

    <section class="section section--muted" v-if="relatedPosts.length">
      <div class="container">
        <h2 class="section-title">{{ t('blog.relatedPosts') }}</h2>
        <div class="related-grid">
          <PostCard v-for="related in relatedPosts" :key="related.id" :post="related" />
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.post-header {
  padding: 32px 0;
}

.breadcrumb {
  font-size: 13px;
  color: var(--p-text-muted-color);
}

.post-header h1 {
  margin-top: 16px;
  margin: 0 0 16px;
  font-size: 34px;
  line-height: 1.3;
  max-width: 880px;
}

.post-header__author {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
}

.post-header__author-name {
  font-weight: 600;
}

.post-header__separator {
  color: var(--p-text-muted-color);
}

.post-header__date {
  color: var(--p-text-muted-color);
  font-size: 13px;
}

.avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--p-content-border-color);
  flex-shrink: 0;
}

.avatar--lg {
  width: 56px;
  height: 56px;
}

.cover {
  height: 400px;
  border: 1px dashed var(--p-surface-300);
  border-radius: 8px;
  background: var(--p-content-hover-background);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: var(--p-text-muted-color);
  margin-bottom: 40px;
}

.cover--img {
  border: none;
  object-fit: cover;
  width: 100%;
  display: block;
}

.cover .pi {
  font-size: 32px;
}

.post-header__share {
  margin-left: auto;
  display: flex;
  gap: 8px;
}

.post-body {
  padding-bottom: 40px;
}

.post-body__content {
  line-height: 1.8;
  color: var(--p-text-color);
}

.post-body__content :deep(:first-child) {
  margin-top: 0;
}

.post-body__content :deep(h2) {
  font-size: 22px;
  margin: 32px 0 12px;
}

.post-body__content :deep(h3) {
  font-size: 18px;
  margin: 24px 0 10px;
}

.post-body__content :deep(p) {
  margin: 0 0 16px;
}

.post-body__content :deep(ul),
.post-body__content :deep(ol) {
  margin: 0 0 16px;
  padding-left: 24px;
}

.post-body__content :deep(li) {
  margin-bottom: 6px;
}

.post-body__content :deep(img) {
  max-width: 100%;
  height: auto;
  display: block;
  border-radius: 8px;
  margin: 24px 0;
}

.post-body__content :deep(code) {
  background: var(--p-content-hover-background);
  border-radius: 4px;
  padding: 2px 6px;
  font-size: 0.9em;
}

.post-body__content :deep(blockquote) {
  margin: 24px 0;
  padding: 16px 20px;
  border-left: 3px solid var(--p-primary-500);
  background: var(--p-content-hover-background);
  color: var(--p-text-muted-color);
  font-style: italic;
}

.post-body__content :deep(blockquote p) {
  margin: 0;
}

.share-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: 1px solid var(--p-content-border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-text-muted-color);
  transition: all 0.15s ease;
}

.share-btn:hover {
  color: #fff;
  background: var(--p-primary-500);
  border-color: var(--p-primary-500);
}

.post-footer {
  padding-bottom: 40px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.tags {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: var(--p-text-muted-color);
}

.author-box {
  display: flex;
  gap: 20px;
  align-items: center;
  background: var(--p-content-hover-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 20px;
}

.author-box__name {
  font-weight: 600;
  font-size: 15px;
}

.author-box p {
  margin: 4px 0 0;
  font-size: 13px;
  color: var(--p-text-muted-color);
}

.section--muted {
  background: var(--p-content-hover-background);
}

.related-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 24px;
}

@media (max-width: 900px) {
  .related-grid {
    grid-template-columns: 1fr;
  }

  .post-header__author {
    flex-wrap: wrap;
  }

  .post-header__share {
    margin-left: 0;
    margin-top: 8px;
    width: 100%;
  }
}
</style>
