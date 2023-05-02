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
      beforeEnter: guardMyroute,
      children: [ 
        {
          path: '',
          component: () => import('../components/Hello.vue'),
        },
      ]
    },{
      path: '/login',
      component: () => import('../layouts/PlainLayout.vue'),
      
    }
    ],
})

export default router
