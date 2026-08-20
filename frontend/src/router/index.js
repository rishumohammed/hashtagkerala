import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../pages/HomePage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/districts/:slug',
    name: 'district',
    component: () => import('../pages/DistrictPage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/kerala/:district/:slug',
    name: 'hotel',
    component: () => import('../pages/HotelDetailPage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../pages/AboutPage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/kerala-tourism',
    name: 'tourism',
    component: () => import('../pages/KeralaTourismPage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/tourism-news',
    name: 'news',
    component: () => import('../pages/NewsPage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/tourism-news/:slug',
    name: 'news-detail',
    component: () => import('../pages/NewsDetailPage.vue'),
    meta: { layout: 'BaseLayout' }
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../pages/ContactPage.vue'),
    meta: { layout: 'BaseLayout' }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

export default router
