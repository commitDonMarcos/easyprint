<script setup>
import { ref, onMounted } from 'vue';
import { logout } from '@/api/auth';
import { useRouter } from 'vue-router';
import apiClient from '@/api/client';

const router = useRouter();
const stats = ref(null);

onMounted(async () => {
  try {
    const res = await apiClient.get('/admin/dashboard');
    stats.value = res.data.data;
  } catch (err) {
    console.error('Failed to load stats', err);
  }
});

const handleLogout = async () => {
  try {
    await logout();
  } catch (err) {
    // ignore
  }
  localStorage.removeItem('admin_token');
  router.push('/admin/login');
};
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-slate-950">
    <nav class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
      <button @click="handleLogout" class="text-sm text-red-600 hover:text-red-700">Logout</button>
    </nav>
    <div class="p-8 max-w-7xl mx-auto">
      <div v-if="stats" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-800">
          <p class="text-sm text-gray-500">Visitors</p>
          <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_visitors }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-800">
          <p class="text-sm text-gray-500">DOCX Exports</p>
          <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_docx_exports }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-800">
          <p class="text-sm text-gray-500">PDF Exports</p>
          <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_pdf_exports }}</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-slate-800">
          <p class="text-sm text-gray-500">Projects</p>
          <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_projects }}</p>
        </div>
      </div>
      <p v-else class="text-gray-500 text-center py-12">Loading statistics...</p>
    </div>
  </div>
</template>
