<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import TemplateRenderer from './TemplateRenderer.vue';

const props = defineProps({
    settings: Object,
    template: Object
});

const showShareDropdown = ref(false);
const dropdownRef = ref(null);

const emit = defineEmits(['save', 'export-pdf', 'export-docx']);

const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        showShareDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="h-full flex flex-col bg-slate-100 dark:bg-[#151f32] border-l border-slate-200 dark:border-slate-800">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-[#1a2233] flex justify-between items-center">
            <h2 class="text-base font-bold text-slate-900 dark:text-slate-200">Live Preview</h2>
            <div class="flex items-center gap-3">
                <button 
                    @click="$emit('save')" 
                    class="p-2 text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white rounded-lg transition hover:bg-slate-100 dark:hover:bg-slate-800"
                    title="Save Project"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8l-4-4H8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a3 3 0 100-6 3 3 0 000 6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20v-4h6v4" />
                    </svg>
                </button>

                <div class="relative" ref="dropdownRef">
                    <button 
                        @click.stop="showShareDropdown = !showShareDropdown"
                        class="px-4 py-1.5 border border-slate-300 dark:border-slate-700 hover:border-slate-400 dark:hover:border-slate-500 bg-transparent text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-full text-xs font-bold uppercase tracking-wider transition"
                    >
                        Export
                    </button>
                    
                    <div 
                        v-if="showShareDropdown"
                        class="absolute right-0 mt-2.5 w-56 rounded-xl bg-white dark:bg-[#1a2233] border border-slate-200 dark:border-slate-800 shadow-2xl py-1.5 z-50 overflow-hidden"
                    >
                        <button 
                            @click="$emit('export-pdf'); showShareDropdown = false"
                            class="w-full text-left px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/80 flex items-center gap-2.5 transition"
                        >
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Export PDF Document
                        </button>
                        <button 
                            @click="$emit('export-docx'); showShareDropdown = false"
                            class="w-full text-left px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/80 flex items-center gap-2.5 transition"
                        >
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Export Word (.docx)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative flex-1 overflow-auto p-12 no-scrollbar flex justify-center bg-[#fafafa] dark:bg-[#070b16]">
            <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1.5px,transparent_1.5px)] dark:bg-[radial-gradient(#1e293b_1.5px,transparent_1.5px)] [background-size:20px_20px] pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-[800px] min-h-[1123px] bg-white shadow-2xl">
                <TemplateRenderer 
                    class="template-canvas"
                    :settings="settings"
                    :template="template"
                />
                
                <div class="p-16 space-y-8">
                    <div class="space-y-3">
                        <div class="h-4 bg-gray-50 rounded w-3/4"></div>
                        <div class="h-4 bg-gray-50 rounded w-full"></div>
                        <div class="h-4 bg-gray-50 rounded w-5/6"></div>
                    </div>
                    
                    <div class="py-20 flex flex-col items-center justify-center border-2 border-dashed border-gray-50 rounded-2xl">
                        <svg class="w-16 h-16 text-gray-100 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-gray-200 font-medium">Document Content Area</p>
                    </div>

                    <div class="space-y-3">
                        <div class="h-4 bg-gray-50 rounded w-full"></div>
                        <div class="h-4 bg-gray-50 rounded w-2/3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
