<script setup lang="ts">
import { useCountUp } from '@/composables/useCountUp'

const props = defineProps<{
  target: number
  suffix?: string
  icon?: string
  label: string
}>()

const { value, el: statEl } = useCountUp(props.target)
</script>

<template>
  <div :ref="(r: any) => { statEl = r?.$el ?? r }" class="stat">
    <i v-if="icon" :class="['pi', icon, 'stat__icon']" />
    <div class="stat__value">{{ value }}{{ suffix }}</div>
    <div class="stat__label">{{ label }}</div>
  </div>
</template>

<style scoped>
.stat {
  flex: 1;
  border: 1px solid var(--p-content-border-color);
  border-radius: 16px;
  padding: 20px 16px;
  text-align: center;
  background: var(--p-content-background);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(79, 70, 229, 0.1);
}

.stat__icon {
  font-size: 20px;
  color: var(--p-primary-500);
  margin-bottom: 8px;
  display: block;
}

.stat__value {
  font-size: 28px;
  font-weight: 800;
  background: linear-gradient(135deg, var(--p-primary-600), var(--accent-500));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.stat__label {
  font-size: 12px;
  color: var(--p-text-muted-color);
  margin-top: 4px;
  font-weight: 500;
}
</style>
