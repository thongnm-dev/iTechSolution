<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import { useSeo } from '@/composables/useSeo'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
import Message from 'primevue/message'
import { submitContact } from '@/services/contact.service'

const { t } = useI18n()

useSeo({ title: t('nav.contact'), description: t('contact.heroSubtitle') })

const form = reactive({
  name: '',
  email: '',
  message: '',
})

const submitted = ref(false)
const submitting = ref(false)
const errorMessage = ref('')

async function handleSubmit() {
  submitting.value = true
  errorMessage.value = ''
  try {
    await submitContact({ ...form })
    submitted.value = true
    form.name = ''
    form.email = ''
    form.message = ''
  } catch {
    errorMessage.value = t('contact.errorMessage')
  } finally {
    submitting.value = false
  }
}

const contactInfo = [
  { icon: 'pi-envelope', labelKey: 'contact.emailLabel', value: 'contact@itechsolution.vn' },
  { icon: 'pi-phone', labelKey: 'contact.phone', value: '(028) 1234 5678' },
  { icon: 'pi-map-marker', labelKey: 'contact.address', valueKey: 'contact.addressValue' },
  { icon: 'pi-clock', labelKey: 'contact.workHours', valueKey: 'contact.workHoursValue' },
]
</script>

<template>
  <div>
    <!-- Hero -->
    <section class="contact-hero">
      <div class="contact-hero__blob contact-hero__blob--1" aria-hidden="true" />
      <div class="contact-hero__blob contact-hero__blob--2" aria-hidden="true" />
      <div class="container contact-hero__inner">
        <span v-reveal class="breadcrumb">{{ t('nav.home') }} / <strong>{{ t('contact.breadcrumb') }}</strong></span>
        <h1 v-reveal="60">{{ t('nav.contact') }}</h1>
        <p v-reveal="120" class="contact-hero__subtitle">{{ t('contact.heroSubtitle') }}</p>
      </div>
    </section>

    <!-- Content -->
    <section class="section">
      <div class="container contact-layout">
        <!-- Form -->
        <div v-reveal class="contact-form-wrap">
          <h2 class="contact-form__title">{{ t('contact.formTitle') }}</h2>

          <Message v-if="submitted" severity="success" :closable="false" class="contact__message">
            {{ t('contact.successMessage') }}
          </Message>
          <Message v-if="errorMessage" severity="error" :closable="false" class="contact__message">
            {{ errorMessage }}
          </Message>

          <form class="contact__form" @submit.prevent="handleSubmit">
            <div class="field-row">
              <div class="field">
                <label for="contact-name">{{ t('contact.nameLabel') }}</label>
                <InputText id="contact-name" v-model="form.name" :placeholder="t('contact.namePlaceholder')" required />
              </div>
              <div class="field">
                <label for="contact-email">{{ t('contact.emailLabel') }}</label>
                <InputText id="contact-email" v-model="form.email" type="email" placeholder="email@example.com" required />
              </div>
            </div>
            <div class="field">
              <label for="contact-message">{{ t('contact.messageLabel') }}</label>
              <Textarea id="contact-message" v-model="form.message" rows="6" :placeholder="t('contact.messagePlaceholder')" required />
            </div>
            <Button type="submit" :label="t('home.cta.button')" :loading="submitting" raised />
          </form>
        </div>

        <!-- Info Sidebar -->
        <div v-reveal="150" class="contact-info">
          <h3 class="contact-info__title">{{ t('contact.infoTitle') }}</h3>
          <div class="contact-info__list">
            <div v-for="item in contactInfo" :key="item.labelKey" class="contact-info__item">
              <div class="contact-info__icon-wrap">
                <i :class="['pi', item.icon]" />
              </div>
              <div>
                <div class="contact-info__label">{{ t(item.labelKey) }}</div>
                <div class="contact-info__value">{{ item.valueKey ? t(item.valueKey) : item.value }}</div>
              </div>
            </div>
          </div>

          <div class="contact-info__social">
            <div class="contact-info__social-label">{{ t('contact.followUs') }}</div>
            <div class="contact-info__social-links">
              <a href="#" aria-label="Facebook"><i class="pi pi-facebook" /></a>
              <a href="#" aria-label="LinkedIn"><i class="pi pi-linkedin" /></a>
              <a href="#" aria-label="GitHub"><i class="pi pi-github" /></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
/* ── Hero ────────────────────────────────── */
.contact-hero {
  position: relative;
  background: linear-gradient(160deg, rgba(30, 27, 75, 0.95), rgba(79, 70, 229, 0.85));
  padding: 72px 0 88px;
  overflow: hidden;
  color: #fff;
}

.contact-hero__blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.2;
  pointer-events: none;
}

.contact-hero__blob--1 {
  width: 400px;
  height: 400px;
  background: var(--accent-400);
  top: -120px;
  right: -60px;
}

.contact-hero__blob--2 {
  width: 300px;
  height: 300px;
  background: var(--p-primary-300);
  bottom: -80px;
  left: -40px;
}

.contact-hero__inner {
  position: relative;
  z-index: 1;
  max-width: 680px;
}

.contact-hero .breadcrumb {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.6);
}

.contact-hero .breadcrumb strong {
  color: rgba(255, 255, 255, 0.9);
}

.contact-hero h1 {
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 800;
  line-height: 1.15;
  margin: 20px 0 16px;
  background: linear-gradient(135deg, #fff 30%, var(--accent-400) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.contact-hero__subtitle {
  font-size: 17px;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.7;
  margin: 0;
  max-width: 560px;
}

/* ── Layout ──────────────────────────────── */
.contact-layout {
  display: grid;
  grid-template-columns: 1fr 360px;
  gap: 56px;
  align-items: start;
}

/* ── Form ────────────────────────────────── */
.contact-form-wrap {
  background: var(--p-content-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 20px;
  padding: 36px;
}

.contact-form__title {
  font-size: 22px;
  font-weight: 700;
  margin: 0 0 24px;
}

.contact__message {
  margin-bottom: 20px;
}

.contact__form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.field-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.field label {
  font-size: 13px;
  font-weight: 600;
  color: var(--p-text-color);
}

/* ── Info Sidebar ────────────────────────── */
.contact-info {
  background: var(--p-content-hover-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 20px;
  padding: 32px;
}

.contact-info__title {
  font-size: 18px;
  font-weight: 700;
  margin: 0 0 24px;
}

.contact-info__list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.contact-info__item {
  display: flex;
  gap: 14px;
  align-items: flex-start;
}

.contact-info__icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.contact-info__icon-wrap .pi {
  font-size: 18px;
  color: #fff;
}

.contact-info__label {
  font-size: 12px;
  color: var(--p-text-muted-color);
  font-weight: 500;
  margin-bottom: 2px;
}

.contact-info__value {
  font-size: 14px;
  font-weight: 600;
  color: var(--p-text-color);
}

.contact-info__social {
  margin-top: 28px;
  padding-top: 24px;
  border-top: 1px solid var(--p-content-border-color);
}

.contact-info__social-label {
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 12px;
}

.contact-info__social-links {
  display: flex;
  gap: 10px;
}

.contact-info__social-links a {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  border: 1px solid var(--p-content-border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--p-text-muted-color);
  transition: all 0.25s ease;
}

.contact-info__social-links a:hover {
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  color: #fff;
  border-color: transparent;
  text-decoration: none;
}

.contact-info__social-links .pi {
  font-size: 18px;
}

/* ── Responsive ──────────────────────────── */
@media (max-width: 900px) {
  .contact-layout {
    grid-template-columns: 1fr;
  }

  .field-row {
    grid-template-columns: 1fr;
  }
}
</style>
