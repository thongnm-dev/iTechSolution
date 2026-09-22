<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import PostCard from '@/components/blog/PostCard.vue'
import { getPosts } from '@/services/blog.service'
import type { Post } from '@/types/blog'

const { t } = useI18n()
const posts = ref<Post[]>([])
const loaded = ref(false)

onMounted(async () => {
  const result = await getPosts({ page: 1, pageSize: 3 })
  posts.value = result.data
  loaded.value = true
})
</script>

<template>
  <section v-if="!loaded || posts.length" class="section">
    <div class="container">
      <div v-reveal class="section-header section-header--row">
        <h2 class="section-title">{{ t('home.blogPreview.title') }}</h2>
        <RouterLink to="/blog">{{ t('home.blogPreview.viewAll') }} &gt;</RouterLink>
      </div>
      <div class="posts-grid">
        <PostCard v-for="(post, index) in posts" :key="post.id" v-reveal="index * 100" :post="post" />
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

.posts-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 24px;
}

@media (max-width: 900px) {
  .posts-grid {
    grid-template-columns: 1fr;
  }
}
</style>
