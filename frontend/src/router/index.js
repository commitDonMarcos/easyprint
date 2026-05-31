import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import Dashboard from '@/views/Dashboard.vue';
import Editor from '@/views/Editor.vue';
import AdminLogin from '@/views/AdminLogin.vue';
import AdminDashboard from '@/views/AdminDashboard.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: { requiresSession: true },
  },
  {
    path: '/projects/:id/edit',
    name: 'projects.edit',
    component: Editor,
    meta: { requiresSession: true },
  },
  {
    path: '/admin/login',
    name: 'admin.login',
    component: AdminLogin,
  },
  {
    path: '/admin',
    name: 'admin.dashboard',
    component: AdminDashboard,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('admin_token');
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'admin.login' });
  } else {
    next();
  }
});

export default router;
