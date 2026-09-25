<script setup lang="ts">
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import Select from 'primevue/select'
import { useLocaleStore } from '@/stores/locale.store'
import type { Locale } from '@/i18n'

const { t } = useI18n()

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
    :aria-label="t('a11y.language')"
    class="lang-select"
  />
</template>

<style scoped>
.lang-select {
  width: 92px;
}
</style>
