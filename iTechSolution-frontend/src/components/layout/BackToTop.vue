<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const visible = ref(false)

function onScroll() {
  visible.value = window.scrollY > 400
}

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<template>
  <Transition name="fade-up">
    <button
      v-if="visible"
      type="button"
      class="back-to-top"
      :aria-label="t('a11y.backToTop')"
      @click="scrollToTop"
    >
      <i class="pi pi-arrow-up" />
    </button>
  </Transition>
</template>

<style scoped>
.back-to-top {
  position: fixed;
  bottom: 32px;
  right: 32px;
  z-index: 40;
  width: 48px;
  height: 48px;
  border-radius: 14px;
  border: none;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.back-to-top:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 32px rgba(79, 70, 229, 0.4);
}

.fade-up-enter-active,
.fade-up-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-up-enter-from,
.fade-up-leave-to {
  opacity: 0;
  transform: translateY(16px);
}
</style>
