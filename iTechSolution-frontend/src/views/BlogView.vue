<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'
import InputText from 'primevue/inputtext'
import Paginator, { type PageState } from 'primevue/paginator'
import PostCard from '@/components/blog/PostCard.vue'
import { getCategories, getPosts } from '@/services/blog.service'
import type { Category, Post } from '@/types/blog'

const { t } = useI18n()

const posts = ref<Post[]>([])
const categories = ref<Category[]>([])
const total = ref(0)
const page = ref(1)
const pageSize = 6
const search = ref('')
const activeCategory = ref<string | null>(null)

async function loadPosts() {
  const result = await getPosts({
    page: page.value,
    pageSize,
    search: search.value || undefined,
    category: activeCategory.value ?? undefined,
  })
  posts.value = result.data
  total.value = result.total
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
    <section class="blog-header">
      <div class="container">
        <span class="breadcrumb">{{ t('nav.home') }} / <strong>{{ t('nav.blog') }}</strong></span>
        <h1 class="section-title">{{ t('blog.title') }}</h1>
      </div>
    </section>

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

    <section class="container blog-content">
      <div class="blog-content__main">
        <p v-if="!posts.length" class="empty-state">Chưa có bài viết nào.</p>
        <div v-else class="posts-grid">
          <PostCard v-for="post in posts" :key="post.id" :post="post" />
        </div>
        <Paginator
          :rows="pageSize"
          :total-records="total"
          :first="(page - 1) * pageSize"
          @page="onPageChange"
        />
      </div>

      <aside class="blog-content__sidebar">
        <div class="widget">
          <div class="widget__title">Danh mục</div>
          <RouterLink v-for="category in categories" :key="category.slug" to="/blog" @click.prevent="selectCategory(category.slug)">
            {{ category.name }}
          </RouterLink>
        </div>
      </aside>
    </section>
  </div>
</template>

<style scoped>
.blog-header {
  background: var(--p-content-hover-background);
  padding: 32px 0;
  border-bottom: 1px solid var(--p-content-border-color);
}

.breadcrumb {
  font-size: 13px;
  color: var(--p-text-muted-color);
}

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
  padding: 6px 14px;
  font-size: 13px;
  color: var(--p-text-color);
  cursor: pointer;
}

.chip--active {
  border-color: var(--p-primary-600);
  background: var(--p-primary-600);
  color: #fff;
}

.blog-content {
  display: flex;
  gap: 40px;
  padding: 40px 24px 80px;
}

.blog-content__main {
  flex: 2.6;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.empty-state {
  color: var(--p-text-muted-color);
  text-align: center;
  padding: 60px 0;
}

.posts-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 28px;
}

.blog-content__sidebar {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.widget {
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 18px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  font-size: 13px;
}

.widget__title {
  font-weight: 600;
  font-size: 14px;
}

@media (max-width: 900px) {
  .blog-content {
    flex-direction: column;
  }

  .posts-grid {
    grid-template-columns: 1fr;
  }
}
</style>
