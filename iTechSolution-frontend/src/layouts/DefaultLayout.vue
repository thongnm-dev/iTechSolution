<script setup lang="ts">
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import BackToTop from '@/components/layout/BackToTop.vue'
</script>

<template>
  <a href="#main-content" class="skip-link">Bỏ qua đến nội dung chính</a>
  <AppHeader />
  <main id="main-content" class="app-main">
    <slot />
  </main>
  <AppFooter />
  <BackToTop />
</template>

<style scoped>
.skip-link {
  position: fixed;
  top: -100%;
  left: 16px;
  z-index: 999;
  padding: 12px 24px;
  background: var(--p-primary-600);
  color: #fff;
  font-weight: 700;
  font-size: 14px;
  border-radius: 0 0 10px 10px;
  text-decoration: none;
  transition: top 0.2s ease;
}

.skip-link:focus {
  top: 0;
  color: #fff;
  text-decoration: none;
}

.app-main {
  flex: 1;
}
</style>
