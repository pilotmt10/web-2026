import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CatalogView from "@/views/CatalogView.vue";
import LoginView from "@/views/LoginView.vue";
import EmptyLayout from "@/layouts/EmptyLayout.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/catalog',
      name: 'catalog',
      component: CatalogView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: {
        layout: EmptyLayout
      }
    },
  ],
})

export default router
