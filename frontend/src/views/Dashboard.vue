<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { getProjects } from '@/api/projects';
import { getTemplates } from '@/api/templates';

const router = useRouter();
const projects = ref([]);
const templates = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const [projectsRes, templatesRes] = await Promise.all([
      getProjects(),
      getTemplates(),
    ]);
    projects.value = projectsRes.data.data;
    templates.value = templatesRes.data.data;
  } catch (err) {
    console.error('Failed to load data', err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="min-h-screen bg-gray-50 dark:bg-slate-950">
    <nav class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <h1 class="text-xl font-bold text-gray-900 dark:text-white">easyPrint</h1>
          <div class="flex items-center gap-4">
            <button @click="router.push('/')" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900">Home</button>
          </div>
        </div>
      </div>
    </nav>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white">My Projects</h2>
          <button @click="showNewProjectModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
            New Project
          </button>
        </div>
        <div v-if="loading" class="text-center py-12 text-gray-500">Loading...</div>
        <div v-else-if="projects.length === 0" class="text-center py-12 bg-white dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-800">
          <p class="text-gray-500">No projects yet. Create your first one!</p>
        </div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="project in projects" :key="project.id" class="bg-white dark:bg-slate-900 rounded-xl border border-gray-200 dark:border-slate-800 p-6 hover:shadow-md transition">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">{{ project.project_name }}</h3>
            <p class="text-sm text-gray-500 mb-4">{{ project.template?.name || 'No template' }}</p>
            <button @click="router.push(`/projects/${project.id}/edit`)" class="w-full py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
              Edit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
