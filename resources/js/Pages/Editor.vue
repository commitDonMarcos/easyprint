<script setup>
import { ref, reactive, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

import Toast from '@/Components/Toast.vue';
import PreviewPanel from '@/Components/Editor/PreviewPanel.vue';
import Layout1Controller from '@/Components/Editor/layout1/controller/layout1Controller.vue';
import Layout2Controller from '@/Components/Editor/layout2/controller/layout2Controller.vue';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { exportToDocx } from '@/Utils/docx_export';

const props = defineProps({
    project: Object,
    templates: Array
});

const settings = reactive({
    headerLines: props.project.settings_json?.headerLines || props.project.template?.json_structure?.default_settings?.headerLines || {
        top: { text: 'REPUBLIC OF THE PHILIPPINES', bold: false, italic: false, fontSize: 14, textTransform: 'uppercase', color: '#000000' },
        middle: { text: 'NUEVA ECIJA UNIVERSITY OF SCIENCE AND TECHNOLOGY', bold: true, italic: false, fontSize: 18, textTransform: 'uppercase', color: '#000000' },
        bottom: { text: 'CARRANGLAN CAMPUS', bold: false, italic: false, fontSize: 14, textTransform: 'uppercase', color: '#000000' }
    },
    fontFamily: props.project.settings_json?.fontFamily || props.project.template?.json_structure?.default_settings?.fontFamily || 'Inter',
    letterSpacing: props.project.settings_json?.letterSpacing ?? props.project.template?.json_structure?.default_settings?.letterSpacing ?? 1,
    textAlign: props.project.settings_json?.textAlign || props.project.template?.json_structure?.default_settings?.textAlign || 'center',
    divider: {
        enabled: props.project.settings_json?.divider?.enabled ?? props.project.template?.json_structure?.default_settings?.divider?.enabled ?? true,
        thickness: props.project.settings_json?.divider?.thickness ?? props.project.template?.json_structure?.default_settings?.divider?.thickness ?? 2,
        color: props.project.settings_json?.divider?.color ?? props.project.template?.json_structure?.default_settings?.divider?.color ?? '#000000',
        text: props.project.settings_json?.divider?.text ?? props.project.template?.json_structure?.default_settings?.divider?.text ?? '',
        top: props.project.settings_json?.divider?.top ?? props.project.template?.json_structure?.default_settings?.divider?.top ?? 20,
        padding: props.project.settings_json?.divider?.padding ?? props.project.template?.json_structure?.default_settings?.divider?.padding ?? 8,
        textColor: props.project.settings_json?.divider?.textColor ?? props.project.template?.json_structure?.default_settings?.divider?.textColor ?? '#ffffff',
        fontSize: props.project.settings_json?.divider?.fontSize ?? props.project.template?.json_structure?.default_settings?.divider?.fontSize ?? 10,
        bold: props.project.settings_json?.divider?.bold ?? props.project.template?.json_structure?.default_settings?.divider?.bold ?? true,
        italic: props.project.settings_json?.divider?.italic ?? props.project.template?.json_structure?.default_settings?.divider?.italic ?? false,
        letterSpacing: props.project.settings_json?.divider?.letterSpacing ?? props.project.template?.json_structure?.default_settings?.divider?.letterSpacing ?? 3,
    },
    verticalDivider: {
        enabled: (props.project.settings_json?.verticalDivider?.enabled ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.enabled ?? true),
        color: (props.project.settings_json?.verticalDivider?.color ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.color ?? '#000000'),
        thinColor: (props.project.settings_json?.verticalDivider?.thinColor ?? props.project.settings_json?.verticalDivider?.color ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.thinColor ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.color ?? '#000000'),
        thickColor: (props.project.settings_json?.verticalDivider?.thickColor ?? props.project.settings_json?.verticalDivider?.color ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.thickColor ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.color ?? '#000000'),
        thinWidth: (props.project.settings_json?.verticalDivider?.thinWidth ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.thinWidth ?? 2),
        thickWidth: (props.project.settings_json?.verticalDivider?.thickWidth ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.thickWidth ?? 5),
        gap: (props.project.settings_json?.verticalDivider?.gap ?? props.project.template?.json_structure?.default_settings?.verticalDivider?.gap ?? 6)
    },
    margin: props.project.settings_json?.margin ?? props.project.template?.json_structure?.default_settings?.margin ?? 20,
    headerTop: props.project.settings_json?.headerTop ?? props.project.template?.json_structure?.default_settings?.headerTop ?? 0,
    lineHeight: props.project.settings_json?.lineHeight ?? props.project.template?.json_structure?.default_settings?.lineHeight ?? 1.2,
    logoSize: props.project.settings_json?.logoSize ?? props.project.template?.json_structure?.default_settings?.logoSize ?? 80,
    logos: props.project.settings_json?.logos || props.project.template?.json_structure?.default_settings?.logos || {
        left_0: null,
        left_1: null,
        right_0: null
    }
});

const currentTemplate = ref(props.project.template);

const toast = ref({ message: '', type: 'success' });
const showToast = (message, type = 'success') => {
    toast.value = { message: '', type };
    setTimeout(() => { toast.value = { message, type }; }, 10);
};

const activeControllerComponent = computed(() => {
    const slug = currentTemplate.value?.slug;
    if (slug === 'layout-1') {
        return Layout1Controller;
    }
    if (slug === 'layout-4') {
        return Layout2Controller;
    }
    return Layout1Controller;
});

const saveProject = async () => {
    try {
        await axios.put(route('projects.update', props.project.id), {
            settings_json: settings
        });
        showToast('Project saved successfully!', 'success');
    } catch (err) {
        showToast('Failed to save project. Please try again.', 'error');
    }
};

const exportPDF = async () => {
    const element = document.querySelector('.template-canvas');
    if (!element) return;

    try {
        const canvas = await html2canvas(element, {
            scale: 2,
            useCORS: true,
            logging: false,
            backgroundColor: '#ffffff'
        });
        
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save(`${props.project.project_name}.pdf`);

        trackAnalytics('pdf_export');
    } catch (err) {
        console.error('Export failed', err);
        showToast('PDF export failed. Please try again.', 'error');
    }
};

const exportDocx = async () => {
    try {
        await exportToDocx(settings, props.project);
        trackAnalytics('docx_export');
    } catch (err) {
        console.error('DOCX Export failed', err);
        showToast('Word export failed. Please try again.', 'error');
    }
};

const trackAnalytics = async (action) => {
    try {
        await axios.post(route('analytics.track'), {
            action: action,
            template_id: currentTemplate.value?.id,
            metadata: { project_id: props.project.id }
        });
    } catch (err) {
        console.error('Analytics tracking failed', err);
    }
};
</script>

<template>
    <Head title="Editor" />

    <Toast
        :message="toast.message"
        :type="toast.type"
        @close="toast.message = ''"
    />

    <AppLayout>
        <div class="h-[calc(100vh-80px)] overflow-hidden">
            <div class="flex h-full w-full">
                <div class="w-1/3 min-w-[360px] max-w-[420px] flex flex-col gap-4 overflow-y-auto no-scrollbar px-6 pb-10">
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider px-1 mt-4">
                        Editing: {{ project.project_name }}
                    </div>
                    
                    <component 
                        :is="activeControllerComponent" 
                        :settings="settings"
                        :template="currentTemplate"
                    />
                </div>

                <div class="flex-1 overflow-hidden h-full">
                    <PreviewPanel 
                        :settings="settings"
                        :template="currentTemplate"
                        @save="saveProject"
                        @export-pdf="exportPDF"
                        @export-docx="exportDocx"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}
.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}
.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
</style>
