import { createRouter, createWebHistory } from 'vue-router'
import PortalLayout from '../layouts/PortalLayout.vue'

function guardMyroute(to, from, next)
{
 var isAuthenticated= false;
 var authentificated = window.sessionStorage.getItem('auth') ? JSON.parse(sessionStorage.getItem('auth')) : false
if(authentificated)
    isAuthenticated = true;
  else
    isAuthenticated= false;
    
  if(isAuthenticated) 
  {
    next(); 
  } 
  else
  {
    next('/login'); 
  }
}

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: PortalLayout,
      //beforeEnter: guardMyroute,
      children: [ 
        {
          path: '',
          component: () => import('../views/Dashboard.vue'),
        },
      ]
    },{
      path: '/user',
      component: () => import('../layouts/PlainLayout.vue'),
      children: [
        {
          path: '/login',
          component: () => import('../components/Login.vue'),
        },
        {
          path: '/register',
          component: () => import('../components/Register.vue'),
        },
      ]
    },
    {
      path: '/admin',
      component: () => import('../layouts/AdminLayout.vue'),
      beforeEnter: guardMyroute,
      children: [
        {
          path: '',
          component: () => import('../components/AdminTable.vue'),
        },
      ]
    }
    ],
})

export default router
