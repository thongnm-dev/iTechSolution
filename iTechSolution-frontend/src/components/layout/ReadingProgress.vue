<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

const progress = ref(0)

function onScroll() {
  const docHeight = document.documentElement.scrollHeight - window.innerHeight
  progress.value = docHeight > 0 ? Math.min((window.scrollY / docHeight) * 100, 100) : 0
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<template>
  <div class="reading-progress" role="progressbar" :aria-valuenow="Math.round(progress)">
    <div class="reading-progress__bar" :style="{ width: `${progress}%` }" />
  </div>
</template>

<style scoped>
.reading-progress {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  z-index: 100;
  background: transparent;
  pointer-events: none;
}

.reading-progress__bar {
  height: 100%;
  background: linear-gradient(90deg, var(--p-primary-500), var(--accent-400));
  transition: width 0.1s linear;
  border-radius: 0 2px 2px 0;
}
</style>
