<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import Carousel from 'primevue/carousel'

const { t } = useI18n()

const testimonials = [
  {
    quote:
      'iTechSolution đã giúp chúng tôi xây dựng nền tảng thương mại điện tử ổn định. Tốc độ tải trang cải thiện rõ rệt và doanh thu online tăng 40% chỉ sau 3 tháng.',
    name: 'Nguyễn Minh Hoàng',
    role: 'Giám đốc điều hành, ShopViet',
    avatar: 'https://randomuser.me/api/portraits/men/32.jpg',
  },
  {
    quote:
      'Đội ngũ chuyên nghiệp, bàn giao đúng tiến độ. Hệ thống quản lý nội bộ mới giúp chúng tôi tiết kiệm hàng chục giờ làm việc mỗi tuần.',
    name: 'Trần Thị Thu Hà',
    role: 'Trưởng phòng Vận hành, LogiPro',
    avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
  },
  {
    quote:
      'Từ tư vấn kiến trúc đến triển khai cloud, mọi thứ đều minh bạch và tối ưu chi phí. Chúng tôi chắc chắn sẽ tiếp tục hợp tác cho các dự án tiếp theo.',
    name: 'Lê Quốc Bảo',
    role: 'Nhà sáng lập, EduNext',
    avatar: 'https://randomuser.me/api/portraits/men/76.jpg',
  },
  {
    quote:
      'Giao diện mới hiện đại, chuẩn SEO và tải nhanh trên di động. Lượng khách hàng tiềm năng để lại thông tin tăng gấp đôi so với website cũ.',
    name: 'Phạm Anh Tuấn',
    role: 'Giám đốc Marketing, VinaTravel',
    avatar: 'https://randomuser.me/api/portraits/men/41.jpg',
  },
  {
    quote:
      'Hỗ trợ sau bàn giao rất tận tâm và nhanh chóng. iTechSolution thực sự là đối tác công nghệ dài hạn mà chúng tôi tin tưởng.',
    name: 'Đỗ Thị Mai Lan',
    role: 'Trưởng phòng CNTT, HealthCare Plus',
    avatar: 'https://randomuser.me/api/portraits/women/65.jpg',
  },
]

const responsiveOptions = [
  { breakpoint: '1200px', numVisible: 3, numScroll: 1 },
  { breakpoint: '900px', numVisible: 2, numScroll: 1 },
  { breakpoint: '600px', numVisible: 1, numScroll: 1 },
]
</script>

<template>
  <section class="section section--testimonials">
    <div class="container">
      <div v-reveal class="section-header">
        <h2 class="section-title section-title--center">{{ t('home.testimonials.title') }}</h2>
      </div>
      <Carousel
        v-reveal="100"
        :value="testimonials"
        :numVisible="3"
        :numScroll="1"
        :responsiveOptions="responsiveOptions"
        :circular="true"
        :autoplayInterval="5000"
        :showIndicators="true"
        class="testimonials-carousel"
      >
        <template #item="{ data }">
          <div class="testimonial-card">
            <div class="testimonial-card__quote-icon" aria-hidden="true">
              <i class="pi pi-quote-right" />
            </div>
            <p class="testimonial-card__text">"{{ data.quote }}"</p>
            <div class="testimonial-card__author">
              <img
                class="testimonial-card__avatar"
                :src="data.avatar"
                :alt="data.name"
                loading="lazy"
              />
              <div>
                <div class="testimonial-card__name">{{ data.name }}</div>
                <div class="testimonial-card__role">{{ data.role }}</div>
              </div>
            </div>
          </div>
        </template>
      </Carousel>
    </div>
  </section>
</template>

<style scoped>
.section--testimonials {
  background: var(--p-content-background);
}

.section-title--center {
  text-align: center;
  margin-bottom: 48px;
}

.testimonials-carousel {
  max-width: 1120px;
  margin: 0 auto;
}

.testimonial-card {
  background: var(--p-content-hover-background);
  border-radius: 20px;
  padding: 28px 24px 24px;
  margin: 8px 12px;
  height: calc(100% - 16px);
  min-height: 200px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  position: relative;
  border-top: 3px solid transparent;
  border-image: linear-gradient(90deg, var(--p-primary-500), var(--accent-400)) 1;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(79, 70, 229, 0.08);
}

.testimonial-card__quote-icon {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--p-primary-500), var(--p-primary-700));
  display: flex;
  align-items: center;
  justify-content: center;
}

.testimonial-card__quote-icon .pi {
  font-size: 18px;
  color: #fff;
}

.testimonial-card__text {
  margin: 0;
  font-size: 14px;
  color: var(--p-text-color);
  line-height: 1.7;
  flex: 1;
}

.testimonial-card__author {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: auto;
  padding-top: 16px;
  border-top: 1px solid var(--p-content-border-color);
}

.testimonial-card__avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  object-fit: cover;
  background: var(--p-content-border-color);
  flex-shrink: 0;
  border: 2px solid var(--p-primary-200);
}

.testimonial-card__name {
  font-size: 14px;
  font-weight: 700;
}

.testimonial-card__role {
  font-size: 12px;
  color: var(--p-text-muted-color);
  margin-top: 2px;
}

.testimonials-carousel :deep(.p-carousel-item) {
  display: flex;
}

.testimonials-carousel :deep(.p-carousel-indicator-list) {
  margin-top: 12px;
}
</style>
