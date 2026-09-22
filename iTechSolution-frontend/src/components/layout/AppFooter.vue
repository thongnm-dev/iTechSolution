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
        <p>
          iTechSolution đồng hành cùng doanh nghiệp trong hành trình chuyển đổi số — từ
          phát triển web, ứng dụng di động đến giải pháp backend và triển khai cloud.
        </p>
      </div>

      <div class="app-footer__col">
        <div class="app-footer__heading">{{ t('footer.company') }}</div>
        <RouterLink to="/about">{{ t('nav.about') }}</RouterLink>
        <RouterLink to="/portfolio">{{ t('nav.portfolio') }}</RouterLink>
        <RouterLink to="/blog">{{ t('nav.blog') }}</RouterLink>
      </div>

      <div class="app-footer__col">
        <div class="app-footer__heading">{{ t('footer.services') }}</div>
        <RouterLink to="/services">Phát triển Web</RouterLink>
        <RouterLink to="/services">Giải pháp Backend &amp; API</RouterLink>
      </div>

      <div class="app-footer__col">
        <div class="app-footer__heading">{{ t('footer.newsletter') }}</div>
        <form class="app-footer__newsletter" @submit.prevent>
          <label for="footer-email" class="sr-only">{{ t('footer.newsletterPlaceholder') }}</label>
          <InputText id="footer-email" type="email" :placeholder="t('footer.newsletterPlaceholder')" size="small" />
          <Button :label="t('footer.subscribe')" size="small" />
        </form>
      </div>
    </div>

    <div class="app-footer__bottom">© {{ year }} iTechSolution. {{ t('footer.rights') }}</div>
  </footer>
</template>

<style scoped>
.app-footer {
  background: var(--p-surface-900);
  color: var(--p-surface-300);
  padding: 56px 0 24px;
  margin-top: auto;
}

.app-footer__grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1.4fr;
  gap: 32px;
}

.app-footer__col {
  display: flex;
  flex-direction: column;
  gap: 10px;
  font-size: 13px;
}

.app-footer__col a {
  color: var(--p-surface-300);
}

.app-footer__brand p {
  margin: 0;
  color: var(--p-surface-400);
}

.app-footer__logo {
  font-weight: 700;
  font-size: 18px;
  color: #fff;
}

.app-footer__heading {
  color: #fff;
  font-weight: 600;
  margin-bottom: 4px;
}

.app-footer__newsletter {
  display: flex;
  gap: 8px;
}

.app-footer__bottom {
  text-align: center;
  font-size: 12px;
  color: var(--p-surface-500);
  border-top: 1px solid var(--p-surface-800);
  margin-top: 32px;
  padding-top: 16px;
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
</style>
