<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
import Message from 'primevue/message'
import { submitContact } from '@/services/contact.service'

const { t } = useI18n()

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
    errorMessage.value = 'Đã có lỗi xảy ra, vui lòng thử lại sau.'
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <div class="container section contact">
    <h1 class="section-title">{{ t('nav.contact') }}</h1>
    <p class="section-subtitle">
      Bạn có dự án hoặc cần tư vấn giải pháp công nghệ? Hãy để lại thông tin, đội ngũ
      iTechSolution sẽ liên hệ và phản hồi trong vòng 24 giờ làm việc.
    </p>

    <Message v-if="submitted" severity="success" :closable="false" class="contact__message">
      Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất.
    </Message>
    <Message v-if="errorMessage" severity="error" :closable="false" class="contact__message">
      {{ errorMessage }}
    </Message>

    <form class="contact__form" @submit.prevent="handleSubmit">
      <div class="field">
        <label for="contact-name">Họ và tên</label>
        <InputText id="contact-name" v-model="form.name" required />
      </div>
      <div class="field">
        <label for="contact-email">Email</label>
        <InputText id="contact-email" v-model="form.email" type="email" required />
      </div>
      <div class="field">
        <label for="contact-message">Nội dung</label>
        <Textarea id="contact-message" v-model="form.message" rows="5" required />
      </div>
      <Button type="submit" :label="t('home.cta.button')" :loading="submitting" />
    </form>
  </div>
</template>

<style scoped>
.contact {
  max-width: 560px;
}

.contact__message {
  margin-bottom: 24px;
}

.contact__form {
  display: flex;
  flex-direction: column;
  gap: 20px;
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
</style>
