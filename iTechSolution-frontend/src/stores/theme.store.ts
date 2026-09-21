import { defineStore } from 'pinia'

function readStoredDark(): boolean {
  try {
    return localStorage.getItem('theme') === 'dark'
  } catch {
    return false
  }
}

export const useThemeStore = defineStore('theme', {
  state: () => ({
    dark: readStoredDark(),
  }),
  actions: {
    apply() {
      document.documentElement.classList.toggle('dark', this.dark)
    },
    init() {
      this.apply()
    },
    toggle() {
      this.dark = !this.dark
      this.apply()
      try {
        localStorage.setItem('theme', this.dark ? 'dark' : 'light')
      } catch {
        // ignore write failures
      }
    },
  },
})
