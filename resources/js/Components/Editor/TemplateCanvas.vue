<script setup>
import TemplateRenderer from './TemplateRenderer.vue';

defineProps({
    settings: Object,
    template: Object
});
</script>

<template>
    <div class="template-canvas bg-white shadow-sm border border-gray-200">
        <TemplateRenderer :settings="settings" :template="template" />
    </div>
</template>
