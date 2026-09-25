<script setup lang="ts">
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useRoute } from 'vue-router'
import Button from 'primevue/button'
import LanguageSwitcher from './LanguageSwitcher.vue'
import { useThemeStore } from '@/stores/theme.store'

const { t } = useI18n()
const route = useRoute()
const themeStore = useThemeStore()
const mobileOpen = ref(false)

const navLinks = [
  { to: '/', key: 'home' },
  { to: '/about', key: 'about' },
  { to: '/services', key: 'services' },
  { to: '/portfolio', key: 'portfolio' },
  { to: '/blog', key: 'blog' },
]

function closeMobile() {
  mobileOpen.value = false
}
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
        <RouterLink to="/contact" class="app-header__cta-desktop">
          <Button :label="t('nav.cta')" size="small" />
        </RouterLink>
        <button
          class="app-header__hamburger"
          type="button"
          aria-label="Menu"
          @click="mobileOpen = !mobileOpen"
        >
          <i :class="mobileOpen ? 'pi pi-times' : 'pi pi-bars'" />
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <Transition name="slide">
      <div v-if="mobileOpen" class="mobile-menu">
        <nav class="mobile-menu__nav">
          <RouterLink
            v-for="link in navLinks"
            :key="link.key"
            :to="link.to"
            class="mobile-menu__link"
            :class="{ 'mobile-menu__link--active': route.path === link.to }"
            @click="closeMobile"
          >
            {{ t(`nav.${link.key}`) }}
          </RouterLink>
          <RouterLink to="/contact" class="mobile-menu__cta" @click="closeMobile">
            <Button :label="t('nav.cta')" class="mobile-menu__cta-btn" />
          </RouterLink>
        </nav>
      </div>
    </Transition>
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
  backdrop-filter: blur(12px);
}

.app-header__inner {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
}

.app-header__logo {
  font-weight: 800;
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
  font-weight: 500;
  text-decoration: none;
  position: relative;
  padding: 4px 0;
}

.app-header__link::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(90deg, var(--p-primary-500), var(--accent-400));
  border-radius: 2px;
  transition: width 0.3s ease;
}

.app-header__link:hover::after,
.app-header__link.router-link-exact-active::after {
  width: 100%;
}

.app-header__link:hover,
.app-header__link.router-link-exact-active {
  color: var(--p-primary-600);
}

.app-header__actions {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-shrink: 0;
}

.app-header__theme-toggle {
  border: 1px solid var(--p-surface-300);
  background: transparent;
  border-radius: 8px;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--p-text-color);
  transition: border-color 0.2s ease;
}

.app-header__theme-toggle:hover {
  border-color: var(--p-primary-400);
}

.app-header__hamburger {
  display: none;
  border: 1px solid var(--p-surface-300);
  background: transparent;
  border-radius: 8px;
  width: 36px;
  height: 36px;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--p-text-color);
  transition: border-color 0.2s ease;
}

.app-header__hamburger:hover {
  border-color: var(--p-primary-400);
}

/* ── Mobile Menu ─────────────────────────── */
.mobile-menu {
  display: none;
  position: absolute;
  top: var(--header-height);
  left: 0;
  right: 0;
  background: var(--p-content-background);
  border-bottom: 1px solid var(--p-content-border-color);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
  z-index: 49;
}

.mobile-menu__nav {
  display: flex;
  flex-direction: column;
  padding: 16px 24px 24px;
  gap: 4px;
}

.mobile-menu__link {
  display: block;
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 500;
  color: var(--p-text-color);
  text-decoration: none;
  transition: background 0.2s ease;
}

.mobile-menu__link:hover,
.mobile-menu__link--active {
  background: var(--p-content-hover-background);
  color: var(--p-primary-600);
  text-decoration: none;
}

.mobile-menu__cta {
  margin-top: 8px;
  text-decoration: none;
}

.mobile-menu__cta-btn {
  width: 100%;
}

/* ── Transitions ─────────────────────────── */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateY(-8px);
  opacity: 0;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .app-header__nav {
    display: none;
  }

  .app-header__cta-desktop {
    display: none;
  }

  .app-header__hamburger {
    display: flex;
  }

  .mobile-menu {
    display: block;
  }
}
</style>
