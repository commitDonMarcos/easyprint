<script setup>
import { ref } from 'vue';
import TextEditor from '@/Components/Editor/TextEditor.vue';
import LogoUploader from '@/Components/Editor/LogoUploader.vue';
import DividerSettings from '@/Components/Editor/DividerSettings.vue';
import MarginController from '@/Components/Editor/MarginController.vue';

const props = defineProps({
    settings: {
        type: Object,
        required: true
    },
    template: {
        type: Object,
        required: true
    }
});

const activeTab = ref('text'); // text, logos, divider, margins

const handleLogoUpload = (payload) => {
    props.settings.logos[payload.slotId] = payload.url;
};
</script>

<template>
    <div class="flex flex-col gap-4">
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 dark:border-slate-800/80">
            <button 
                v-for="tab in ['text', 'logos', 'divider', 'margins']" 
                :key="tab"
                @click="activeTab = tab"
                :class="[
                    activeTab === tab 
                        ? 'border-white text-white font-semibold' 
                        : 'border-transparent text-slate-400 hover:text-slate-200',
                    'whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm capitalize transition'
                ]"
            >
                {{ tab }}
            </button>
        </div>

        <!-- Dynamic Content -->
        <div v-show="activeTab === 'text'">
            <TextEditor 
                v-model:headerLines="settings.headerLines"
                v-model:letterSpacing="settings.letterSpacing"
                v-model:fontFamily="settings.fontFamily"
                v-model:textAlign="settings.textAlign"
            />
        </div>

        <div v-show="activeTab === 'logos'" class="space-y-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider px-4 pt-4">Logo Assets</h3>
            
            <LogoUploader 
                v-for="(type, index) in template?.json_structure?.slots?.left" 
                :key="'left-' + index"
                :slot-id="'left_' + index"
                :current-logo="settings.logos['left_' + index]"
                @uploaded="handleLogoUpload"
            />
            <LogoUploader 
                v-for="(type, index) in template?.json_structure?.slots?.right" 
                :key="'right-' + index"
                :slot-id="'right_' + index"
                :current-logo="settings.logos['right_' + index]"
                @uploaded="handleLogoUpload"
            />

            <!-- Logo Sizing Card -->
            <div class="mx-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 space-y-3">
                <div class="flex justify-between items-center">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Logo Size (Height)</label>
                    <span class="text-xs text-gray-500 font-bold bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ settings.logoSize }}px</span>
                </div>
                <div class="flex items-center gap-4">
                    <input 
                        type="range" 
                        min="40" 
                        max="150" 
                        step="5"
                        v-model.number="settings.logoSize"
                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                </div>
                <p class="text-[10px] text-gray-400">Aspect ratio is locked automatically to prevent stretching or distortion.</p>
            </div>
        </div>

        <div v-show="activeTab === 'divider'" class="space-y-4">
            <DividerSettings 
                v-model:enabled="settings.divider.enabled"
                v-model:thickness="settings.divider.thickness"
                v-model:color="settings.divider.color"
                v-model:text="settings.divider.text"
                v-model:top="settings.divider.top"
                v-model:padding="settings.divider.padding"
                v-model:textColor="settings.divider.textColor"
                v-model:fontSize="settings.divider.fontSize"
                v-model:bold="settings.divider.bold"
                v-model:italic="settings.divider.italic"
                v-model:letterSpacing="settings.divider.letterSpacing"
            />
        </div>

        <div v-show="activeTab === 'margins'">
            <MarginController 
                v-model:margin="settings.margin"
                v-model:headerTop="settings.headerTop"
                v-model:lineHeight="settings.lineHeight"
            />
        </div>
    </div>
</template>
