<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import { useSeo } from '@/composables/useSeo'
import { useJsonLd } from '@/composables/useJsonLd'
import HeroSection from '@/components/sections/HeroSection.vue'
import AboutSection from '@/components/sections/AboutSection.vue'
import ServicesSection from '@/components/sections/ServicesSection.vue'
import PortfolioSection from '@/components/sections/PortfolioSection.vue'
import TestimonialsSection from '@/components/sections/TestimonialsSection.vue'
import BlogPreviewSection from '@/components/sections/BlogPreviewSection.vue'
import CtaSection from '@/components/sections/CtaSection.vue'

const { t } = useI18n()

useSeo({
  title: t('nav.home'),
  description: t('home.hero.subtitle'),
})

useJsonLd({
  '@context': 'https://schema.org',
  '@type': 'Organization',
  name: 'iTechSolution',
  url: 'https://itechsolution.vn',
  logo: 'https://itechsolution.vn/favicon.svg',
  contactPoint: {
    '@type': 'ContactPoint',
    telephone: '(028) 1234 5678',
    contactType: 'customer service',
  },
  sameAs: [
    'https://www.facebook.com/itechsolution',
    'https://www.linkedin.com/company/itechsolution',
    'https://github.com/itechsolution',
  ],
})
</script>

<template>
  <div>
    <HeroSection />
    <AboutSection />
    <ServicesSection />
    <PortfolioSection />
    <TestimonialsSection />
    <BlogPreviewSection />
    <CtaSection />
  </div>
</template>
