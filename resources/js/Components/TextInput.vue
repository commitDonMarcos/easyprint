<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="w-full rounded-xl border border-gray-300 bg-white/50 px-4 py-3 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm transition-all duration-300 focus:border-cyan-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-800/80 dark:bg-slate-950/40 dark:text-slate-200 dark:placeholder-slate-500 dark:focus:border-cyan-500 dark:focus:bg-slate-950/80 dark:focus:ring-cyan-500/30"
        v-model="model"
        ref="input"
    />
</template>
