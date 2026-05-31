<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import TemplateRenderer from '@/Components/Editor/TemplateRenderer.vue';
import Toast from '@/Components/Toast.vue';

const props = defineProps({
    projects: Array,
    templates: Array
});

const showNewProjectModal = ref(false);
const showPreviewModal = ref(false);
const selectedProject = ref(null);

const toast = ref({ message: '', type: 'success' });
const showToast = (message, type = 'success') => {
    toast.value = { message: '', type };
    setTimeout(() => { toast.value = { message, type }; }, 10);
};

const openPreview = (project) => {
    selectedProject.value = project;
    showPreviewModal.value = true;
};

const showDeleteConfirmModal = ref(false);
const projectToDelete = ref(null);

const confirmDelete = (project) => {
    projectToDelete.value = project;
    showDeleteConfirmModal.value = true;
};

const executeDelete = () => {
    if (!projectToDelete.value) return;
    
    router.delete(route('projects.destroy', projectToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteConfirmModal.value = false;
            projectToDelete.value = null;
            showToast('Project deleted successfully!', 'success');
        },
        onError: () => {
            showDeleteConfirmModal.value = false;
            projectToDelete.value = null;
            showToast('Failed to delete project. Please try again.', 'error');
        }
    });
};

const form = useForm({
    project_name: '',
    template_id: 1,
    settings_json: {}
});

watch(() => form.template_id, (newId) => {
    const template = props.templates?.find(t => t.id === parseInt(newId));
    if (template && template.json_structure?.default_settings) {
        form.settings_json = JSON.parse(JSON.stringify(template.json_structure.default_settings));
    }
}, { immediate: true });

const createProject = () => {
    form.post(route('projects.store'), {
        onSuccess: () => {
            showNewProjectModal.value = false;
            showToast('Project created successfully!', 'success');
        },
        onError: () => {
            showToast('Failed to create project. Please check the name.', 'error');
        }
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Projects</h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="projects.length === 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center border border-gray-200 dark:border-gray-700">
                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">No projects found</h3>
                    <p class="text-gray-500 mt-2">Start by creating your first document header.</p>
                    <button 
                        @click="showNewProjectModal = true"
                        class="mt-6 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Create Project
                    </button>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 max-w-5xl mx-auto gap-8">
                    <button 
                        @click="showNewProjectModal = true"
                        class="bg-white dark:bg-[#1a2333]/50 border-2 border-dashed border-gray-300 dark:border-slate-800 rounded-xl p-6 group transition-all duration-300 flex flex-col items-center justify-center h-full text-center focus:outline-none min-h-[380px] shadow-sm hover:shadow-md hover:border-indigo-500 dark:hover:border-indigo-400 hover:bg-slate-50/50 dark:hover:bg-slate-900/30"
                    >
                        <div class="w-16 h-16 rounded-full border-2 border-dashed border-gray-300 dark:border-slate-800/80 bg-gray-50/50 dark:bg-slate-950/20 text-gray-400 dark:text-slate-500 group-hover:border-indigo-500 dark:group-hover:border-indigo-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-950/20 flex items-center justify-center transition-all duration-300 mb-4 shadow-inner">
                            <svg class="w-8 h-8 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h4 class="text-gray-800 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 font-bold text-lg transition-colors duration-300">
                            New Project
                        </h4>
                        <p class="text-xs mt-2 max-w-[220px] leading-relaxed text-gray-500 dark:text-slate-400">
                            Create a custom school header from layouts & templates
                        </p>
                    </button>

                    <div 
                        v-for="project in projects" 
                        :key="project.id"
                        class="bg-white dark:bg-[#1a2333] border border-gray-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition group flex flex-col"
                    >
                        <div class="h-48 bg-slate-50 dark:bg-slate-950/20 flex items-center justify-center overflow-hidden relative border-b border-gray-100 dark:border-slate-800/50 group">
                            <div class="absolute inset-0 flex items-center justify-center origin-center scale-[0.38] sm:scale-[0.52] md:scale-[0.38] lg:scale-[0.52] group-hover:scale-[0.4] sm:group-hover:scale-[0.55] md:group-hover:scale-[0.4] lg:group-hover:scale-[0.55] transition-transform duration-500 pointer-events-none">
                                <TemplateRenderer 
                                    :settings="project.settings_json"
                                    :template="project.template"
                                    class="w-[850px] min-w-[850px] flex-shrink-0 shadow-2xl"
                                />
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-50/10 dark:from-slate-950/10 to-transparent pointer-events-none"></div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-5">
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900 dark:text-white line-clamp-1 leading-tight">{{ project.project_name }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ project.template.name }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 mt-auto">
                                <div class="flex gap-3">
                                    <Link 
                                        :href="route('projects.edit', project.id)" 
                                        class="flex-[3] text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition shadow-sm"
                                    >
                                        Edit Project
                                    </Link>
                                    <button 
                                        @click="openPreview(project)"
                                        class="flex-[1.2] py-2.5 bg-transparent text-gray-700 dark:text-gray-100 border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 rounded-lg text-sm font-semibold transition shadow-sm text-center"
                                    >
                                        Preview
                                    </button>
                                </div>
                                <button 
                                    @click="confirmDelete(project)"
                                    class="w-full py-2.5 text-gray-500 hover:text-red-500 hover:bg-red-50/50 dark:text-slate-400 dark:hover:text-red-400 dark:hover:bg-red-950/20 rounded-lg transition border border-gray-200 dark:border-slate-700 flex justify-center items-center gap-2 text-sm font-medium"
                                >
                                    <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showPreviewModal && selectedProject" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div @click="showPreviewModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-90 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

                <div class="inline-block align-middle text-left transform transition-all sm:my-8 sm:align-middle max-w-5xl w-full">
                    <div class="fixed top-6 right-6 z-[60]">
                        <button @click="showPreviewModal = false" class="bg-black/50 hover:bg-black/70 text-white p-3 rounded-full backdrop-blur-md transition shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="p-4 md:p-8 max-h-[95vh] overflow-auto no-scrollbar flex flex-col items-center">
                        <div class="bg-white border border-gray-100 w-full max-w-[800px] min-h-[1100px] mx-auto p-0 print:shadow-none print:m-0 relative group">
                            <TemplateRenderer 
                                :settings="selectedProject.settings_json"
                                :template="selectedProject.template"
                            />
                            <div class="p-12">
                                <div class="h-4 w-3/4 bg-gray-100 rounded mb-4"></div>
                                <div class="h-4 w-full bg-gray-100 rounded mb-4"></div>
                                <div class="h-4 w-5/6 bg-gray-100 rounded mb-4"></div>
                                <div class="space-y-4 mt-12">
                                    <div class="h-32 w-full border-2 border-dashed border-gray-100 rounded-xl flex items-center justify-center text-gray-300 font-medium">
                                        Your document content will go here...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showNewProjectModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="showNewProjectModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="createProject" class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Create New Project</h3>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name</label>
                            <input v-model="form.project_name" type="text" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Q1 Exam Header">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Select Header Layout</label>
                            
                            <div class="grid grid-cols-2 gap-4 max-h-[360px] overflow-y-auto pr-1">
                                <div
                                    v-for="t in templates"
                                    :key="t.id"
                                    @click="form.template_id = t.id"
                                    :class="[
                                        form.template_id === t.id 
                                            ? 'border-indigo-600 ring-2 ring-indigo-500 bg-indigo-50/50 dark:bg-indigo-900/20' 
                                            : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
                                    ]"
                                    class="border rounded-xl p-3 transition flex flex-col group relative cursor-pointer"
                                >
                                    <div 
                                        v-if="form.template_id === t.id"
                                        class="absolute top-2 right-2 z-10 bg-indigo-600 text-white rounded-full p-1"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>

                                    <div class="h-24 bg-white dark:bg-gray-900 rounded-lg border border-gray-150 dark:border-gray-800 p-2 flex flex-col justify-between mb-2 shadow-inner overflow-hidden select-none">
                                        <div class="flex items-center w-full justify-between h-full">
                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                <div 
                                                    v-for="i in (t.json_structure?.slots?.left?.length || 0)" 
                                                    :key="'l-'+i" 
                                                    class="w-4 h-4 rounded-full bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center flex-shrink-0 shadow-sm"
                                                >
                                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></div>
                                                </div>
                                            </div>

                                            <div 
                                                v-if="t.json_structure?.vertical_dividers" 
                                                class="flex items-center gap-0.5 px-0.5 flex-shrink-0"
                                            >
                                                <div class="w-[1px] h-8 bg-amber-400"></div>
                                                <div class="w-[2px] h-8 bg-blue-600"></div>
                                            </div>

                                            <div class="flex-1 px-2 flex flex-col justify-center gap-1 items-center">
                                                <div class="h-1 bg-gray-300 dark:bg-gray-600 rounded w-10"></div>
                                                <div class="h-1.5 bg-gray-400 dark:bg-gray-500 rounded w-14"></div>
                                                <div class="h-1 bg-gray-300 dark:bg-gray-600 rounded w-8"></div>
                                            </div>

                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                <div 
                                                    v-for="i in (t.json_structure?.slots?.right?.length || 0)" 
                                                    :key="'r-'+i" 
                                                    class="w-4 h-4 rounded-full bg-indigo-200 dark:bg-indigo-800 flex items-center justify-center flex-shrink-0 shadow-sm"
                                                >
                                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div 
                                            v-if="t.json_structure?.default_settings?.divider?.enabled"
                                            :class="t.json_structure?.default_settings?.divider?.text ? 'h-3 bg-gray-400 flex items-center justify-center rounded-sm' : 'h-1 bg-indigo-600 rounded-full'"
                                            class="w-full mt-1.5"
                                        >
                                            <div 
                                                v-if="t.json_structure?.default_settings?.divider?.text" 
                                                class="h-[2px] bg-white rounded-full w-12"
                                            ></div>
                                        </div>
                                    </div>

                                    <div class="flex-1 flex flex-col justify-between">
                                        <span class="text-xs font-bold text-gray-800 dark:text-gray-200 block group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-tight line-clamp-2">
                                            {{ t.name }}
                                        </span>
                                        <div class="flex justify-between items-center mt-1.5 pt-1.5 border-t border-gray-100 dark:border-gray-700/50">
                                            <span class="text-[9px] font-bold text-gray-400 uppercase">
                                                {{ t.slug === 'layout-4' ? 'Layout 2' : 'Layout 1' }}
                                            </span>
                                            <span class="text-[9px] font-extrabold uppercase tracking-wider text-green-600 dark:text-green-400">
                                                Free
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showNewProjectModal = false" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">Cancel</button>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-bold hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div v-if="showDeleteConfirmModal && projectToDelete" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:block sm:p-0">
                <div @click="showDeleteConfirmModal = false" class="fixed inset-0 bg-[#090d16]/80 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-[#111827] border border-gray-200 dark:border-slate-800/80 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full p-6 relative">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-red-500/10 dark:bg-red-500/10 flex items-center justify-center text-red-500 dark:text-red-400 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Delete Project</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">This action is permanent and cannot be undone.</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-600 dark:text-slate-300 leading-relaxed">
                            Are you sure you want to delete <span class="font-semibold text-gray-900 dark:text-white">"{{ projectToDelete.project_name }}"</span>?
                        </p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button 
                            type="button" 
                            @click="showDeleteConfirmModal = false" 
                            class="px-4 py-2.5 rounded-lg border border-gray-200 dark:border-slate-800 text-sm font-semibold text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition"
                        >
                            Cancel
                        </button>
                        <button 
                            type="button" 
                            @click="executeDelete" 
                            class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-bold shadow-md hover:shadow-red-600/10 transition"
                        >
                            Delete Project
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <Toast
            :message="toast.message"
            :type="toast.type"
            @close="toast.message = ''"
        />
    </AppLayout>
</template>
