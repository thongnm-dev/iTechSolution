import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createHead } from '@unhead/vue/client'
import PrimeVue from 'primevue/config'
import 'primeicons/primeicons.css'

import App from './App.vue'
import router from './router'
import i18n from './i18n'
import primevueConfig from './plugins/primevue'
import { useLocaleStore } from './stores/locale.store'
import { useThemeStore } from './stores/theme.store'
import { vReveal } from './directives/reveal'
import './assets/styles/main.scss'

const app = createApp(App)
const head = createHead()

app.use(createPinia())
app.use(head)
app.use(router)
app.use(i18n)
app.use(PrimeVue, { theme: primevueConfig })
app.directive('reveal', vReveal)

useLocaleStore().init()
useThemeStore().init()

router.isReady().then(() => {
  app.mount('#app')
  const preloader = document.getElementById('preloader')
  if (preloader) {
    preloader.classList.add('hide')
    setTimeout(() => preloader.remove(), 400)
  }
})
