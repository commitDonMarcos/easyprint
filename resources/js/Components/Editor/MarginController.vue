<script setup>
const props = defineProps({
    margin: Number,
    headerTop: Number,
    lineHeight: Number
});

const emit = defineEmits(['update:margin', 'update:headerTop', 'update:lineHeight']);
</script>

<template>
    <div class="space-y-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Page Spacing</h3>
        
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Outer Margin (Side/Bottom) (px)</label>
                <input 
                    type="range" 
                    min="0" 
                    max="100" 
                    :value="margin" 
                    @input="$emit('update:margin', parseInt($event.target.value))"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                />
                <div class="text-right text-xs text-gray-400 mt-1">{{ margin }}px</div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Top Margin (Distance from top) (px)</label>
                <input 
                    type="range" 
                    min="0" 
                    max="200" 
                    :value="headerTop" 
                    @input="$emit('update:headerTop', parseInt($event.target.value))"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                />
                <div class="text-right text-xs text-gray-400 mt-1">{{ headerTop }}px</div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Line Height (Between text lines)</label>
                <input 
                    type="range" 
                    min="0.8" 
                    max="3.0"
                    step="0.1"
                    :value="lineHeight" 
                    @input="$emit('update:lineHeight', parseFloat($event.target.value))"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                />
                <div class="text-right text-xs text-gray-400 mt-1">{{ lineHeight }}×</div>
            </div>
        </div>
        
        <p class="text-[10px] text-gray-400 italic">Note: Top margin helps align the header with physical paper edges or pre-printed stationery.</p>
    </div>
</template>
