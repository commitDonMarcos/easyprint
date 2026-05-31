<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getProjects, updateProject } from '@/api/projects';
import { trackEvent } from '@/api/analytics';

const route = useRoute();
const project = ref(null);
const loading = ref(true);
const saving = ref(false);

onMounted(async () => {
  try {
    const res = await getProjects();
    project.value = res.data.data.find(p => p.id === parseInt(route.params.id));
  } catch (err) {
    console.error('Failed to load project', err);
  } finally {
    loading.value = false;
  }
});

const saveProject = async () => {
  saving.value = true;
  try {
    await updateProject(project.value.id, { settings_json: project.value.settings_json });
    alert('Saved!');
  } catch (err) {
    console.error('Save failed', err);
  } finally {
    saving.value = false;
  }
};

const exportPdf = async () => {
  try {
    const html2canvas = (await import('html2canvas')).default;
    const jsPDF = (await import('jspdf')).default;
    const element = document.querySelector('.template-canvas');
    if (!element) return;
    const canvas = await html2canvas(element, { scale: 2, useCORS: true });
    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    pdf.addImage(imgData, 'PNG', 0, 0, 210, (canvas.height * 210) / canvas.width);
    pdf.save(`${project.value.project_name}.pdf`);
    await trackEvent('pdf_export', project.value.template_id);
  } catch (err) {
    console.error('PDF export failed', err);
  }
};
</script>

<template>
  <div v-if="loading" class="min-h-screen flex items-center justify-center">Loading...</div>
  <div v-else-if="project" class="min-h-screen bg-gray-50 dark:bg-slate-950">
    <nav class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 px-6 py-4 flex items-center justify-between">
      <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ project.project_name }}</h1>
      <div class="flex gap-3">
        <button @click="saveProject" :disabled="saving" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold">Save</button>
        <button @click="exportPdf" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold">Export PDF</button>
      </div>
    </nav>
    <div class="p-8 flex justify-center">
      <div class="template-canvas bg-white p-8 shadow-lg max-w-[850px] w-full min-h-[400px]">
        <p class="text-gray-400 text-center">Template editor loaded. Settings: {{ JSON.stringify(project.settings_json).slice(0, 100) }}...</p>
      </div>
    </div>
  </div>
</template>
