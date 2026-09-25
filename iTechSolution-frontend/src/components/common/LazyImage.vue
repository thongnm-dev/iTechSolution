<script setup lang="ts">
import { ref } from 'vue'

defineProps<{
  src: string
  alt: string
  height?: string
}>()

const loaded = ref(false)
const error = ref(false)

function onLoad() {
  loaded.value = true
}

function onError() {
  error.value = true
}
</script>

<template>
  <div class="lazy-img" :style="height ? { height } : undefined">
    <div v-if="!loaded && !error" class="lazy-img__placeholder">
      <i class="pi pi-image" />
    </div>
    <div v-if="error" class="lazy-img__placeholder">
      <i class="pi pi-image" />
    </div>
    <img
      v-if="!error"
      :src="src"
      :alt="alt"
      loading="lazy"
      class="lazy-img__img"
      :class="{ 'lazy-img__img--loaded': loaded }"
      @load="onLoad"
      @error="onError"
    />
  </div>
</template>

<style scoped>
.lazy-img {
  position: relative;
  overflow: hidden;
  background: var(--p-content-hover-background);
}

.lazy-img__placeholder {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-text-muted-color);
  font-size: 28px;
}

.lazy-img__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  opacity: 0;
  transition: opacity 0.4s ease;
}

.lazy-img__img--loaded {
  opacity: 1;
}
</style>
