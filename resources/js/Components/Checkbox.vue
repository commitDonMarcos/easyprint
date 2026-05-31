<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="h-4.5 w-4.5 rounded border-gray-300 text-cyan-600 shadow-sm transition-all duration-200 focus:ring-cyan-500/30 dark:border-slate-800 dark:bg-slate-950/60 dark:text-cyan-500 dark:focus:ring-cyan-500/30 dark:focus:ring-offset-slate-900"
    />
</template>
