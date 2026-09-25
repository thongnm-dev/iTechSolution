<script setup lang="ts">
import { useSeo } from '@/composables/useSeo'
import HeroSection from '@/components/sections/HeroSection.vue'
import AboutSection from '@/components/sections/AboutSection.vue'
import ServicesSection from '@/components/sections/ServicesSection.vue'
import PortfolioSection from '@/components/sections/PortfolioSection.vue'
import TestimonialsSection from '@/components/sections/TestimonialsSection.vue'
import BlogPreviewSection from '@/components/sections/BlogPreviewSection.vue'
import CtaSection from '@/components/sections/CtaSection.vue'

useSeo({
  title: 'Trang chủ',
  description: 'iTechSolution — Đồng hành cùng doanh nghiệp trong chuyển đổi số với giải pháp web, mobile và cloud.',
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
