<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'
import InputText from 'primevue/inputtext'
import Paginator, { type PageState } from 'primevue/paginator'
import Skeleton from 'primevue/skeleton'
import PostCard from '@/components/blog/PostCard.vue'
import { useSeo } from '@/composables/useSeo'
import { getCategories, getPosts } from '@/services/blog.service'
import type { Category, Post } from '@/types/blog'

const { t } = useI18n()

useSeo({ title: 'Blog', description: 'Cập nhật tin tức công nghệ, chia sẻ kiến thức và kinh nghiệm từ đội ngũ iTechSolution.' })

const posts = ref<Post[]>([])
const categories = ref<Category[]>([])
const total = ref(0)
const page = ref(1)
const pageSize = 6
const search = ref('')
const activeCategory = ref<string | null>(null)
const loading = ref(true)

async function loadPosts() {
  loading.value = true
  const result = await getPosts({
    page: page.value,
    pageSize,
    search: search.value || undefined,
    category: activeCategory.value ?? undefined,
  })
  posts.value = result.data
  total.value = result.total
  loading.value = false
}

function selectCategory(slug: string | null) {
  activeCategory.value = slug
  page.value = 1
}

function onPageChange(event: PageState) {
  page.value = event.page + 1
}

watch([search, activeCategory, page], loadPosts)

onMounted(async () => {
  categories.value = await getCategories()
  await loadPosts()
})
</script>

<template>
  <div>
    <!-- Hero -->
    <section class="blog-hero">
      <div class="blog-hero__blob blog-hero__blob--1" aria-hidden="true" />
      <div class="blog-hero__blob blog-hero__blob--2" aria-hidden="true" />
      <div class="container blog-hero__inner">
        <span v-reveal class="breadcrumb">{{ t('nav.home') }} / <strong>{{ t('nav.blog') }}</strong></span>
        <h1 v-reveal="60">{{ t('blog.title') }}</h1>
        <p v-reveal="120" class="blog-hero__subtitle">{{ t('blog.heroSubtitle') }}</p>
      </div>
    </section>

    <!-- Filters -->
    <section class="blog-filters">
      <div class="container blog-filters__inner">
        <div class="chips">
          <button
            type="button"
            class="chip"
            :class="{ 'chip--active': activeCategory === null }"
            @click="selectCategory(null)"
          >
            {{ t('blog.allCategories') }}
          </button>
          <button
            v-for="category in categories"
            :key="category.slug"
            type="button"
            class="chip"
            :class="{ 'chip--active': activeCategory === category.slug }"
            @click="selectCategory(category.slug)"
          >
            {{ category.name }}
          </button>
        </div>
        <IconField>
          <InputIcon class="pi pi-search" />
          <InputText v-model="search" :placeholder="t('blog.searchPlaceholder')" />
        </IconField>
      </div>
    </section>

    <!-- Content -->
    <section class="section">
      <div class="container">
        <!-- Loading skeleton -->
        <div v-if="loading" class="posts-grid">
          <div v-for="i in pageSize" :key="i" class="skeleton-card">
            <Skeleton height="200px" border-radius="16px" />
            <Skeleton width="40%" height="12px" class="skeleton-card__meta" />
            <Skeleton width="80%" height="18px" />
            <Skeleton width="100%" height="14px" />
            <Skeleton width="60%" height="14px" />
          </div>
        </div>

        <!-- Posts -->
        <template v-else>
          <p v-if="!posts.length" class="empty-state">{{ t('blog.empty') }}</p>
          <div v-else class="posts-grid">
            <PostCard v-for="(post, index) in posts" :key="post.id" v-reveal="index * 80" :post="post" />
          </div>
        </template>

        <Paginator
          v-if="total > pageSize"
          :rows="pageSize"
          :total-records="total"
          :first="(page - 1) * pageSize"
          @page="onPageChange"
        />
      </div>
    </section>
  </div>
</template>

<style scoped>
/* ── Hero ────────────────────────────────── */
.blog-hero {
  position: relative;
  background: linear-gradient(160deg, rgba(30, 27, 75, 0.95), rgba(79, 70, 229, 0.85));
  padding: 72px 0 88px;
  overflow: hidden;
  color: #fff;
}

.blog-hero__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.2;
  pointer-events: none;
}

.blog-hero__blob--1 {
  width: 400px;
  height: 400px;
  background: var(--accent-400);
  top: -120px;
  right: -60px;
}

.blog-hero__blob--2 {
  width: 300px;
  height: 300px;
  background: var(--p-primary-300);
  bottom: -80px;
  left: -40px;
}

.blog-hero__inner {
  position: relative;
  z-index: 1;
  max-width: 680px;
}

.blog-hero .breadcrumb {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.6);
}

.blog-hero .breadcrumb strong {
  color: rgba(255, 255, 255, 0.9);
}

.blog-hero h1 {
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 800;
  line-height: 1.15;
  margin: 20px 0 16px;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.blog-hero__subtitle {
  font-size: 17px;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin: 0;
  max-width: 560px;
}

/* ── Filters ─────────────────────────────── */
.blog-filters {
  border-bottom: 1px solid var(--p-content-border-color);
  padding: 20px 0;
}

.blog-filters__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
  flex-wrap: wrap;
}

.chips {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.chip {
  border: 1px solid var(--p-content-border-color);
  background: var(--p-content-background);
  border-radius: 999px;
  padding: 6px 16px;
  font-size: 13px;
  font-weight: 500;
  color: var(--p-text-color);
  cursor: pointer;
  transition: all 0.2s ease;
}

.chip:hover {
  border-color: var(--p-primary-400);
  color: var(--p-primary-600);
}

.chip--active {
  border-color: var(--p-primary-600);
  background: var(--p-primary-600);
  color: #fff;
}

/* ── Grid ────────────────────────────────── */
.posts-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.empty-state {
  color: var(--p-text-muted-color);
  text-align: center;
  padding: 60px 0;
}

/* ── Skeleton ────────────────────────────── */
.skeleton-card {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.skeleton-card__meta {
  margin-top: 4px;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .posts-grid {
    grid-template-columns: 1fr;
  }
}
</style>
