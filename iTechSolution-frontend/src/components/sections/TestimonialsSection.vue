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
  <section class="section section--muted">
    <div class="container">
      <h2 v-reveal class="section-title section-title--center">{{ t('home.testimonials.title') }}</h2>
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
            <p>"{{ data.quote }}"</p>
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
.section--muted {
  background: var(--p-content-hover-background);
}

.section-title--center {
  text-align: center;
  margin-bottom: 40px;
}

.testimonials-carousel {
  max-width: 1120px;
  margin: 0 auto;
}

.testimonial-card {
  background: var(--p-content-background);
  border: 1px solid var(--p-content-border-color);
  border-radius: 8px;
  padding: 24px;
  margin: 8px 12px;
  height: calc(100% - 16px);
  min-height: 180px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.testimonial-card p {
  margin: 0;
  font-size: 13px;
  color: var(--p-text-color);
  line-height: 1.6;
}

.testimonial-card__author {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: auto;
}

.testimonial-card__avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  background: var(--p-content-border-color);
  flex-shrink: 0;
}

.testimonial-card__name {
  font-size: 13px;
  font-weight: 600;
}

.testimonial-card__role {
  font-size: 11px;
  color: var(--p-text-muted-color);
}

/* Equal-height carousel items */
.testimonials-carousel :deep(.p-carousel-item) {
  display: flex;
}

.testimonials-carousel :deep(.p-carousel-indicator-list) {
  margin-top: 8px;
}
</style>
