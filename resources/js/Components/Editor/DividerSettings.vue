<script setup>
const props = defineProps({
    enabled: Boolean,
    thickness: Number,
    color: String,
    text: String,
    top: Number,
    padding: Number,
    textColor: String,
    fontSize: Number,
    bold: Boolean,
    italic: Boolean,
    letterSpacing: Number
});

const emit = defineEmits([
    'update:enabled', 
    'update:thickness', 
    'update:color', 
    'update:text', 
    'update:top', 
    'update:padding',
    'update:textColor',
    'update:fontSize',
    'update:bold',
    'update:italic',
    'update:letterSpacing'
]);
</script>

<template>
    <div class="space-y-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Divider</h3>
            <button 
                @click="$emit('update:enabled', !enabled)"
                :class="enabled ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
            >
                <span :class="enabled ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
            </button>
        </div>

        <div v-if="enabled" class="space-y-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Divider Text (Optional)</label>
                <input 
                    type="text" 
                    :value="text" 
                    @input="$emit('update:text', $event.target.value)"
                    placeholder="Enter text to display on divider..."
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Thickness (px)</label>
                    <input 
                        type="range" 
                        min="1" 
                        max="50" 
                        :value="thickness" 
                        @input="$emit('update:thickness', parseInt($event.target.value))"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                    <div class="text-right text-[10px] text-gray-400 mt-1">{{ thickness }}px</div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Spacing (Top)</label>
                    <input 
                        type="range" 
                        min="0" 
                        max="100" 
                        :value="top" 
                        @input="$emit('update:top', parseInt($event.target.value))"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                    <div class="text-right text-[10px] text-gray-400 mt-1">{{ top }}px</div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Color</label>
                <div class="flex items-center gap-2">
                    <input 
                        type="color" 
                        :value="color" 
                        @input="$emit('update:color', $event.target.value)"
                        class="h-8 w-8 rounded border-0 p-0 bg-transparent cursor-pointer"
                    />
                    <input 
                        type="text" 
                        :value="color" 
                        @input="$emit('update:color', $event.target.value)"
                        class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    />
                </div>
            </div>

            <!-- Expandable Divider Text Styling Controls -->
            <div v-if="text && text.trim().length > 0" class="border-t border-gray-100 dark:border-gray-700/60 pt-4 space-y-4">
                <h4 class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Divider Text Styling</h4>
                
                <!-- Text Color -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Text Color</label>
                    <div class="flex items-center gap-2">
                        <input 
                            type="color" 
                            :value="textColor || '#ffffff'" 
                            @input="$emit('update:textColor', $event.target.value)"
                            class="h-8 w-8 rounded border-0 p-0 bg-transparent cursor-pointer"
                        />
                        <input 
                            type="text" 
                            :value="textColor || '#ffffff'" 
                            @input="$emit('update:textColor', $event.target.value)"
                            class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Text Size -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Text Size</label>
                        <input 
                            type="range" 
                            min="8" 
                            max="24" 
                            :value="fontSize ?? 10" 
                            @input="$emit('update:fontSize', parseInt($event.target.value))"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                        />
                        <div class="text-right text-[10px] text-gray-400 mt-1">{{ fontSize ?? 10 }}px</div>
                    </div>

                    <!-- Text Letter Spacing -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Letter Spacing</label>
                        <input 
                            type="range" 
                            min="0" 
                            max="10" 
                            :value="letterSpacing ?? 3" 
                            @input="$emit('update:letterSpacing', parseInt($event.target.value))"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                        />
                        <div class="text-right text-[10px] text-gray-400 mt-1">{{ letterSpacing ?? 3 }}px</div>
                    </div>
                </div>

                <!-- Text Padding (Banner Height) -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Banner Padding (Height)</label>
                    <input 
                        type="range" 
                        min="2" 
                        max="30" 
                        :value="padding ?? 8" 
                        @input="$emit('update:padding', parseInt($event.target.value))"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                    />
                    <div class="text-right text-[10px] text-gray-400 mt-1">{{ padding ?? 8 }}px</div>
                </div>

                <!-- Text Style (Bold & Italic Toggle Buttons) -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Font Style</label>
                    <div class="flex items-center gap-2">
                        <!-- Bold -->
                        <button
                            type="button"
                            @click="$emit('update:bold', !(bold ?? true))"
                            :class="(bold ?? true) ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200'"
                            class="flex-1 py-1.5 px-3 rounded text-xs font-bold transition hover:opacity-90 flex items-center justify-center gap-1"
                        >
                            <span>B</span>
                            <span class="text-[10px] opacity-75">Bold</span>
                        </button>
                        
                        <!-- Italic -->
                        <button
                            type="button"
                            @click="$emit('update:italic', !(italic ?? false))"
                            :class="(italic ?? false) ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200'"
                            class="flex-1 py-1.5 px-3 rounded text-xs italic transition hover:opacity-90 flex items-center justify-center gap-1"
                        >
                            <span>I</span>
                            <span class="text-[10px] opacity-75">Italic</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
