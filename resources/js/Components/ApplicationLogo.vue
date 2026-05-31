<script setup>
defineProps({
    size: {
        type: String,
        default: 'normal'
    }
});
</script>

<template>
    <div class="flex items-center select-none" :class="size === 'small' ? 'gap-2' : 'gap-3'">
        <!-- Modern SVG Print Loop Logo -->
        <div 
            class="relative flex items-center justify-center rounded-xl bg-gradient-to-tr from-cyan-500 to-indigo-600 shadow-md shadow-cyan-500/20"
            :class="size === 'small' ? 'w-8 h-8 rounded-lg' : 'w-10 h-10'"
        >
            <svg 
                class="text-white" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2.5"
                :style="size === 'small' ? 'width: 16px; height: 16px;' : 'width: 24px; height: 24px;'"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <div 
                class="absolute -inset-0.5 rounded-xl bg-gradient-to-tr from-cyan-400 to-indigo-500 opacity-30 blur-sm -z-10 animate-pulse"
                :class="size === 'small' ? 'rounded-lg' : 'rounded-xl'"
            ></div>
        </div>
        <span 
            class="font-extrabold tracking-tight text-slate-800 dark:text-white leading-none"
            :class="size === 'small' ? 'text-lg' : 'text-2xl'"
        >
            Easy<span class="bg-gradient-to-r from-cyan-500 to-indigo-500 bg-clip-text text-transparent font-black">Print</span>
        </span>
    </div>
</template>
