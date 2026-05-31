<script setup>
const props = defineProps({
    enabled: Boolean,
    thinColor: String,
    thickColor: String,
    thinWidth: Number,
    thickWidth: Number,
    gap: Number
});

defineEmits([
    'update:enabled',
    'update:thinColor',
    'update:thickColor',
    'update:thinWidth',
    'update:thickWidth',
    'update:gap'
]);
</script>

<template>
    <div class="space-y-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mt-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Vertical Dividers</h3>
            <button 
                @click="$emit('update:enabled', !enabled)"
                :class="enabled ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
            >
                <span :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>

        <div v-if="enabled" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Thin Divider Color</label>
                    <div class="flex items-center gap-1.5">
                        <input 
                            type="color" 
                            :value="thinColor" 
                            @input="$emit('update:thinColor', $event.target.value)"
                            class="h-7 w-7 rounded border border-gray-200 dark:border-gray-700 p-0 bg-transparent cursor-pointer"
                        />
                        <input 
                            type="text" 
                            :value="thinColor" 
                            @input="$emit('update:thinColor', $event.target.value)"
                            class="w-full h-7 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-[11px] px-1 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Thick Divider Color</label>
                    <div class="flex items-center gap-1.5">
                        <input 
                            type="color" 
                            :value="thickColor" 
                            @input="$emit('update:thickColor', $event.target.value)"
                            class="h-7 w-7 rounded border border-gray-200 dark:border-gray-700 p-0 bg-transparent cursor-pointer"
                        />
                        <input 
                            type="text" 
                            :value="thickColor" 
                            @input="$emit('update:thickColor', $event.target.value)"
                            class="w-full h-7 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-[11px] px-1 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-medium text-gray-500">Thin Divider Width (px)</label>
                        <span class="text-xs text-gray-400 font-semibold">{{ thinWidth }}px</span>
                    </div>
                    <input 
                        type="range" 
                        min="1" 
                        max="10" 
                        :value="thinWidth" 
                        @input="$emit('update:thinWidth', parseInt($event.target.value))"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-medium text-gray-500">Thick Divider Width (px)</label>
                        <span class="text-xs text-gray-400 font-semibold">{{ thickWidth }}px</span>
                    </div>
                    <input 
                        type="range" 
                        min="2" 
                        max="30" 
                        :value="thickWidth" 
                        @input="$emit('update:thickWidth', parseInt($event.target.value))"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-medium text-gray-500">Gap Between Dividers (px)</label>
                        <span class="text-xs text-gray-400 font-semibold">{{ gap }}px</span>
                    </div>
                    <input 
                        type="range" 
                        min="2" 
                        max="20" 
                        :value="gap" 
                        @input="$emit('update:gap', parseInt($event.target.value))"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
