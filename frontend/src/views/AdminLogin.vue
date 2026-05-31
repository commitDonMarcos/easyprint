<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { login } from '@/api/auth';

const router = useRouter();
const password = ref('');
const error = ref('');

const submit = async () => {
  try {
    const res = await login(password.value);
    localStorage.setItem('admin_token', res.data.token);
    router.push('/admin');
  } catch (err) {
    error.value = err.response?.data?.message || 'Invalid password';
  }
};
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-slate-950 flex items-center justify-center">
    <form @submit.prevent="submit" class="bg-white dark:bg-slate-900 p-8 rounded-xl shadow-md w-full max-w-md">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Admin Login</h1>
      <div v-if="error" class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">{{ error }}</div>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Password</label>
        <input v-model="password" type="password" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white p-2 border" />
      </div>
      <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">Login</button>
    </form>
  </div>
</template>
