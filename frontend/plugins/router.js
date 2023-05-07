import { createRouter, createWebHistory } from 'vue-router'
import PortalLayout from '../layouts/PortalLayout.vue'

function requireLogin(to, from, next) {
  const role = window.sessionStorage.getItem('auth')
  if (role) {
    next()
  } else {
    next('/login')
  }
}
function requireTeacher(to, from, next) {
  const role = window.sessionStorage.getItem('role')
  if (role === 'teacher' || role === 'admin') {
    next()
  } else {
    next('/')
  }
}
function requireAdmin(to, from, next) {
  const role = window.sessionStorage.getItem('role')
  if (role === 'admin') {
    next()
  } else {
    next('/')
  }
}

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: PortalLayout,
      beforeEnter: requireLogin,
      children: [
        {
          path: '',
          component: () => import('../views/Dashboard.vue'),
        },
        {
          path: '/assignments',
          component: () => import('../views/AssignmentsListView.vue'),
        },
        {
          path: '/history',
          component: () => import('../views/HistoryView.vue'),
        },
        {
          path: '/files',
          component: () => import('../views/FilesView.vue'),
          beforeEnter: requireTeacher,
        },
        {
          path: '/results',
          component: () => import('../views/ResultsView.vue'),
          beforeEnter: requireTeacher,
        },
        {
          path: '/create-assignment',
          component: () => import('../views/AssignmentCreationView.vue'),
          beforeEnter: requireTeacher,
        },
        {
          path: '/admin',
          component: () => import('../views/AdminView.vue'),
          beforeEnter: requireAdmin,
        },
      ]
    }, {
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
  ],
})

export default router
