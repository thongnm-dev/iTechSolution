import { defineStore } from 'pinia'
import i18n, { DEFAULT_LOCALE, SUPPORTED_LOCALES, type Locale } from '@/i18n'

export const useLocaleStore = defineStore('locale', {
  state: () => ({
    current: DEFAULT_LOCALE as Locale,
  }),
  actions: {
    init() {
      this.current = i18n.global.locale.value as Locale
    },
    setLocale(next: Locale) {
      if (!SUPPORTED_LOCALES.includes(next)) return
      i18n.global.locale.value = next
      this.current = next
      try {
        localStorage.setItem('locale', next)
      } catch {
        // ignore write failures (private mode, blocked storage, etc.)
      }
      document.documentElement.lang = next
    },
  },
})
