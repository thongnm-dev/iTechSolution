<script setup lang="ts">
import { computed } from 'vue'
import Select from 'primevue/select'
import { useLocaleStore } from '@/stores/locale.store'
import type { Locale } from '@/i18n'

const localeStore = useLocaleStore()

const options: { label: string; value: Locale }[] = [
  { label: 'VI', value: 'vi' },
  { label: 'EN', value: 'en' },
  { label: 'JA', value: 'ja' },
]

const selected = computed<Locale>({
  get: () => localeStore.current,
  set: (value) => localeStore.setLocale(value),
})
</script>

<template>
  <Select
    v-model="selected"
    :options="options"
    option-label="label"
    option-value="value"
    aria-label="Ngôn ngữ"
    class="lang-select"
  />
</template>

<style scoped>
.lang-select {
  width: 92px;
}
</style>
