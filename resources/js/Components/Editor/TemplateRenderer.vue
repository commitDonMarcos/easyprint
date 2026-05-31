<script setup>
import { computed } from 'vue';
import Layout1 from '@/Components/Editor/layout1/view/layout1.vue';
import Layout2 from '@/Components/Editor/layout2/view/layout2.vue';

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

// Securely dispatch layout components. This whitelists approved layout components 
// and prevents any arbitrary component injection or dynamic script executions.
const activeLayoutComponent = computed(() => {
    const slug = props.template?.slug;
    
    if (slug === 'layout-1') {
        return Layout1;
    }
    if (slug === 'layout-4') {
        return Layout2;
    }
    
    // Default safe fallback layout
    return Layout1;
});
</script>

<template>
    <component 
        :is="activeLayoutComponent" 
        :settings="settings" 
        :template="template" 
    />
</template>
