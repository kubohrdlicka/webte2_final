import { createRouter, createWebHistory } from 'vue-router'
import PortalLayout from '../layouts/PortalLayout.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: PortalLayout,
      children: [ 
        {
          path: '',
          component: () => import('../components/Hello.vue'),
        },
      ]
    },
  ],
})

export default router
