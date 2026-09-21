import { createI18n } from 'vue-i18n'
import vi from './locales/vi.json'
import en from './locales/en.json'
import ja from './locales/ja.json'

export type Locale = 'vi' | 'en' | 'ja'
export const SUPPORTED_LOCALES: Locale[] = ['vi', 'en', 'ja']
export const DEFAULT_LOCALE: Locale = 'vi'

function readStoredLocale(): Locale {
  try {
    const stored = localStorage.getItem('locale')
    if (stored && SUPPORTED_LOCALES.includes(stored as Locale)) {
      return stored as Locale
    }
  } catch {
    // localStorage unavailable (private mode, etc.) — fall back silently
  }
  return DEFAULT_LOCALE
}

const i18n = createI18n({
  legacy: false,
  locale: readStoredLocale(),
  fallbackLocale: DEFAULT_LOCALE,
  messages: { vi, en, ja },
})

export default i18n
