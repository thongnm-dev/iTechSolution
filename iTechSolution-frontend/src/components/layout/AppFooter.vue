<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'

const { t } = useI18n()
const year = new Date().getFullYear()
</script>

<template>
  <footer class="app-footer">
    <div class="container app-footer__grid">
      <div class="app-footer__col app-footer__brand">
        <div class="app-footer__logo">iTechSolution</div>
        <p>{{ t('footer.brandDesc') }}</p>
        <div class="app-footer__social">
          <a href="#" aria-label="Facebook"><i class="pi pi-facebook" /></a>
          <a href="#" aria-label="LinkedIn"><i class="pi pi-linkedin" /></a>
          <a href="#" aria-label="GitHub"><i class="pi pi-github" /></a>
        </div>
      </div>

      <div class="app-footer__col">
        <div class="app-footer__heading">{{ t('footer.company') }}</div>
        <RouterLink to="/about">{{ t('nav.about') }}</RouterLink>
        <RouterLink to="/portfolio">{{ t('nav.portfolio') }}</RouterLink>
        <RouterLink to="/blog">{{ t('nav.blog') }}</RouterLink>
        <RouterLink to="/contact">{{ t('nav.contact') }}</RouterLink>
      </div>

      <div class="app-footer__col">
        <div class="app-footer__heading">{{ t('footer.services') }}</div>
        <RouterLink to="/services">{{ t('footer.webDev') }}</RouterLink>
        <RouterLink to="/services">{{ t('footer.mobileDev') }}</RouterLink>
        <RouterLink to="/services">{{ t('footer.backendApi') }}</RouterLink>
        <RouterLink to="/services">{{ t('footer.devops') }}</RouterLink>
      </div>

      <div class="app-footer__col">
        <div class="app-footer__heading">{{ t('footer.newsletter') }}</div>
        <p class="app-footer__newsletter-desc">{{ t('footer.newsletterDesc') }}</p>
        <form class="app-footer__newsletter" @submit.prevent>
          <label for="footer-email" class="sr-only">{{ t('footer.newsletterPlaceholder') }}</label>
          <InputText id="footer-email" type="email" :placeholder="t('footer.newsletterPlaceholder')" size="small" />
          <Button :label="t('footer.subscribe')" size="small" />
        </form>
      </div>
    </div>

    <div class="app-footer__bottom">
      <div class="container app-footer__bottom-inner">
        <span>© {{ year }} iTechSolution. {{ t('footer.rights') }}</span>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.app-footer {
  background: var(--p-surface-900);
  color: var(--p-surface-300);
  padding: 64px 0 0;
  margin-top: auto;
}

.app-footer__grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1.5fr;
  gap: 40px;
}

.app-footer__col {
  display: flex;
  flex-direction: column;
  gap: 10px;
  font-size: 13px;
}

.app-footer__col a {
  color: var(--p-surface-400);
  transition: color 0.2s ease;
}

.app-footer__col a:hover {
  color: #fff;
  text-decoration: none;
}

.app-footer__brand p {
  margin: 0;
  color: var(--p-surface-400);
  line-height: 1.7;
  font-size: 13px;
}

.app-footer__logo {
  font-weight: 800;
  font-size: 20px;
  color: #fff;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.app-footer__social {
  display: flex;
  gap: 8px;
  margin-top: 4px;
}

.app-footer__social a {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  border: 1px solid var(--p-surface-700);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-surface-400);
  transition: all 0.25s ease;
}

.app-footer__social a:hover {
  background: var(--p-primary-600);
  border-color: var(--p-primary-600);
  color: #fff;
}

.app-footer__social .pi {
  font-size: 16px;
}

.app-footer__heading {
  color: #fff;
  font-weight: 700;
  font-size: 14px;
  margin-bottom: 6px;
}

.app-footer__newsletter-desc {
  margin: 0;
  font-size: 13px;
  color: var(--p-surface-400);
  line-height: 1.5;
}

.app-footer__newsletter {
  display: flex;
  gap: 8px;
}

.app-footer__bottom {
  border-top: 1px solid var(--p-surface-800);
  margin-top: 48px;
  padding: 20px 0;
}

.app-footer__bottom-inner {
  text-align: center;
  font-size: 12px;
  color: var(--p-surface-500);
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  overflow: hidden;
}

@media (max-width: 900px) {
  .app-footer__grid {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 500px) {
  .app-footer__grid {
    grid-template-columns: 1fr;
  }
}
</style>
