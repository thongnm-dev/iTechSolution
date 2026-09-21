<script setup lang="ts">
import Button from 'primevue/button'
</script>

<template>
  <div class="container section not-found">
    <h1>404</h1>
    <p>[Không tìm thấy trang bạn yêu cầu]</p>
    <RouterLink to="/">
      <Button label="Về trang chủ" />
    </RouterLink>
  </div>
</template>

<style scoped>
.not-found {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.not-found h1 {
  font-size: 64px;
  margin: 0;
  color: var(--p-primary-600);
}
</style>
