import { createRouter, createWebHistory } from 'vue-router'
import PortalLayout from '../layouts/PortalLayout.vue'
import store from './store'

function requireLogin(to, from, next) {
  const auth = window.sessionStorage.getItem('auth')
  if (auth && !store.state.authentificated) {
    const role = window.sessionStorage.getItem('role')
    const token = window.sessionStorage.getItem('token')
    store.dispatch('login', {token: token, role: role})
  }
  if (auth) {
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
          path: '/assigment/info/:id',
          name: 'assigment-info',
          component: () => import('../views/AssigmentInfoView.vue'),
        },
        {
          path: '/exam/:id',
          name: 'exam',
          component: () => import('../views/ExamView.vue'),
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
        {
          path: '/manual',
          component: () => import('../views/ManualView.vue'),
        }
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
