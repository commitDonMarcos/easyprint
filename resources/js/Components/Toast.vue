<script setup>
import { ref, computed, watch, onUnmounted } from 'vue';

const props = defineProps({
    message: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'success', // success | error | warning | info
    },
    duration: {
        type: Number,
        default: 3500,
    },
});

const emit = defineEmits(['close']);

const visible = ref(false);
const progress = ref(100);
let timer = null;
let progressTimer = null;

const typeConfig = computed(() => {
    const configs = {
        success: {
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
            bg: 'bg-[#0f172a]/95 dark:bg-[#0b0f19]/95',
            border: 'border-emerald-500/40',
            iconBg: 'bg-emerald-500/15',
            iconColor: 'text-emerald-400',
            bar: 'bg-emerald-500',
            title: 'Success',
            textColor: 'text-emerald-400',
            shadow: 'shadow-[0_0_20px_rgba(16,185,129,0.18)]',
        },
        error: {
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
            bg: 'bg-[#0f172a]/95 dark:bg-[#0b0f19]/95',
            border: 'border-red-500/40',
            iconBg: 'bg-red-500/15',
            iconColor: 'text-red-400',
            bar: 'bg-red-500',
            title: 'Error',
            textColor: 'text-red-400',
            shadow: 'shadow-[0_0_20px_rgba(239,68,68,0.18)]',
        },
        warning: {
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
            bg: 'bg-[#0f172a]/95 dark:bg-[#0b0f19]/95',
            border: 'border-amber-500/40',
            iconBg: 'bg-amber-500/15',
            iconColor: 'text-amber-400',
            bar: 'bg-amber-500',
            title: 'Warning',
            textColor: 'text-amber-400',
            shadow: 'shadow-[0_0_20px_rgba(245,158,11,0.18)]',
        },
        info: {
            icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            bg: 'bg-[#0f172a]/95 dark:bg-[#0b0f19]/95',
            border: 'border-cyan-500/40',
            iconBg: 'bg-cyan-500/15',
            iconColor: 'text-cyan-400',
            bar: 'bg-cyan-500',
            title: 'Info',
            textColor: 'text-cyan-400',
            shadow: 'shadow-[0_0_20px_rgba(6,182,212,0.18)]',
        },
    };
    return configs[props.type] || configs.success;
});

const show = () => {
    visible.value = true;
    progress.value = 100;

    clearTimeout(timer);
    clearInterval(progressTimer);

    const step = 100 / (props.duration / 50);
    progressTimer = setInterval(() => {
        progress.value = Math.max(0, progress.value - step);
    }, 50);

    timer = setTimeout(() => {
        close();
    }, props.duration);
};

const close = () => {
    clearTimeout(timer);
    clearInterval(progressTimer);
    visible.value = false;
    setTimeout(() => emit('close'), 350);
};

watch(
    () => props.message,
    (val) => {
        if (val) show();
    },
    { immediate: true }
);

onUnmounted(() => {
    clearTimeout(timer);
    clearInterval(progressTimer);
});
</script>

<template>
    <!-- Positioning wrapper for centering -->
    <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[9999] pointer-events-none flex justify-center w-full max-w-sm px-4">
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 translate-y-4 scale-95"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition-all duration-300 ease-in"
            leave-from-class="opacity-100 translate-y-0 scale-100"
            leave-to-class="opacity-0 translate-y-4 scale-95"
        >
            <div
                v-if="visible && message"
                class="pointer-events-auto w-80 overflow-hidden rounded-2xl border shadow-2xl backdrop-blur-md"
                :class="[typeConfig.bg, typeConfig.border, typeConfig.shadow]"
            >
                <!-- Content Row -->
                <div class="flex items-start gap-3 p-4">
                    <!-- Icon -->
                    <div
                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl"
                        :class="[typeConfig.iconBg, typeConfig.iconColor]"
                        v-html="typeConfig.icon"
                    />

                    <!-- Text -->
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider" :class="typeConfig.textColor">
                            {{ typeConfig.title }}
                        </p>
                        <p class="mt-0.5 text-sm font-medium text-slate-100 leading-snug">
                            {{ message }}
                        </p>
                    </div>

                    <!-- Close Button -->
                    <button
                        @click="close"
                        class="flex-shrink-0 text-slate-400 hover:text-white transition-colors ml-1"
                        aria-label="Dismiss notification"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Auto-dismiss Progress Bar -->
                <div class="h-0.5 w-full bg-white/5">
                    <div
                        class="h-full transition-all duration-50 ease-linear rounded-full"
                        :class="typeConfig.bar"
                        :style="{ width: progress + '%' }"
                    />
                </div>
            </div>
        </Transition>
    </div>
</template>
