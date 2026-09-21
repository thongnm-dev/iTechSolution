import type { RouteRecordRaw } from 'vue-router'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/HomeView.vue'),
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('@/views/AboutView.vue'),
  },
  {
    path: '/services',
    name: 'services',
    component: () => import('@/views/ServicesView.vue'),
  },
  {
    path: '/portfolio',
    name: 'portfolio',
    component: () => import('@/views/PortfolioView.vue'),
  },
  {
    path: '/blog',
    name: 'blog',
    component: () => import('@/views/BlogView.vue'),
  },
  {
    path: '/blog/:slug',
    name: 'blog-detail',
    component: () => import('@/views/BlogDetailView.vue'),
    props: true,
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('@/views/ContactView.vue'),
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('@/views/NotFoundView.vue'),
  },
]

export default routes
