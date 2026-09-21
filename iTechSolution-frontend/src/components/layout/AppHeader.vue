<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'
import LanguageSwitcher from './LanguageSwitcher.vue'
import { useThemeStore } from '@/stores/theme.store'

const { t } = useI18n()
const themeStore = useThemeStore()

const navLinks = [
  { to: '/', key: 'home' },
  { to: '/about', key: 'about' },
  { to: '/services', key: 'services' },
  { to: '/portfolio', key: 'portfolio' },
  { to: '/blog', key: 'blog' },
]
</script>

<template>
  <header class="app-header">
    <div class="container app-header__inner">
      <RouterLink to="/" class="app-header__logo">iTechSolution</RouterLink>

      <nav class="app-header__nav">
        <RouterLink v-for="link in navLinks" :key="link.key" :to="link.to" class="app-header__link">
          {{ t(`nav.${link.key}`) }}
        </RouterLink>
      </nav>

      <div class="app-header__actions">
        <LanguageSwitcher />
        <button
          class="app-header__theme-toggle"
          type="button"
          :aria-label="themeStore.dark ? 'Chuyển sang giao diện sáng' : 'Chuyển sang giao diện tối'"
          @click="themeStore.toggle()"
        >
          <i :class="themeStore.dark ? 'pi pi-sun' : 'pi pi-moon'" />
        </button>
        <RouterLink to="/contact">
          <Button :label="t('nav.cta')" size="small" />
        </RouterLink>
      </div>
    </div>
  </header>
</template>

<style scoped>
.app-header {
  position: sticky;
  top: 0;
  z-index: 50;
  height: var(--header-height);
  background: var(--p-content-background);
  border-bottom: 1px solid var(--p-content-border-color);
}

.app-header__inner {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
}

.app-header__logo {
  font-weight: 700;
  font-size: 20px;
  color: var(--p-text-color);
  text-decoration: none;
  flex-shrink: 0;
}

.app-header__nav {
  display: flex;
  gap: 28px;
  flex: 1;
  justify-content: center;
}

.app-header__link {
  color: var(--p-text-color);
  font-size: 15px;
  text-decoration: none;
}

.app-header__link:hover,
.app-header__link.router-link-exact-active {
  color: var(--p-primary-600);
}

.app-header__actions {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-shrink: 0;
}

.app-header__theme-toggle {
  border: 1px solid var(--p-surface-300);
  background: transparent;
  border-radius: 6px;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--p-text-color);
}

@media (max-width: 900px) {
  .app-header__nav {
    display: none;
  }
}
</style>
