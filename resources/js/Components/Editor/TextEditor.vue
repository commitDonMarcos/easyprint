<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    headerLines: Object,
    letterSpacing: Number,
    fontFamily: String,
    textAlign: String
});

const emit = defineEmits(['update:headerLines', 'update:letterSpacing', 'update:fontFamily', 'update:textAlign']);

// Always render lines in canonical order: top → middle → bottom.
// The saved JSON can store keys in any insertion order; this computed
// guarantees the editor UI never shows them out of sequence.
const CANONICAL_ORDER = ['top', 'middle', 'bottom'];
const orderedKeys = computed(() => {
    const existing = Object.keys(props.headerLines ?? {});
    return [
        ...CANONICAL_ORDER.filter(k => existing.includes(k)),
        ...existing.filter(k => !CANONICAL_ORDER.includes(k)),
    ];
});

const fonts = [
    'Inter', 'Roboto', 'Outfit', 'Playfair Display', 'Montserrat', 'Open Sans', 'Serif', 'Sans-Serif'
];

const transforms = [
    { label: 'None', value: 'none' },
    { label: 'UPPER', value: 'uppercase' },
    { label: 'lower', value: 'lowercase' },
    { label: 'Capitalize First Letter', value: 'capitalize' }
];

const fontSizes = Array.from({ length: 41 }, (_, i) => i + 8); // 8px to 48px

const openDropdown = ref(null);

const toggleDropdown = (part) => {
    if (openDropdown.value === part) {
        openDropdown.value = null;
    } else {
        openDropdown.value = part;
    }
};

const closeDropdowns = () => {
    openDropdown.value = null;
};

onMounted(() => {
    document.addEventListener('click', closeDropdowns);
});

onUnmounted(() => {
    document.removeEventListener('click', closeDropdowns);
});

const updateLine = (part, field, value) => {
    const newLines = { ...props.headerLines };
    newLines[part][field] = value;
    emit('update:headerLines', newLines);
};
</script>

<template>
    <div class="space-y-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Header Content</h3>
        
        <!-- Global Settings -->
        <div class="grid grid-cols-2 gap-4 pb-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Font Family</label>
                <select 
                    :value="fontFamily" 
                    @change="$emit('update:fontFamily', $event.target.value)"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm font-medium"
                >
                    <option v-for="font in fonts" :key="font" :value="font">{{ font }}</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Letter Spacing</label>
                <input 
                    type="range" 
                    min="0" 
                    max="10" 
                    step="0.5"
                    :value="letterSpacing" 
                    @input="$emit('update:letterSpacing', parseFloat($event.target.value))"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 accent-blue-600"
                />
            </div>
            <div class="col-span-2">
                <label class="block text-xs font-medium text-gray-500 mb-1">Text Alignment</label>
                <div class="flex gap-2">
                    <button 
                        v-for="align in ['left', 'center', 'right']" 
                        :key="align"
                        type="button"
                        @click="$emit('update:textAlign', align)"
                        :class="[
                            textAlign === align 
                                ? 'bg-blue-600 text-white border-blue-600 shadow-sm' 
                                : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700',
                            'flex-1 py-1.5 px-3 border rounded-md text-xs font-semibold capitalize transition flex items-center justify-center gap-1.5'
                        ]"
                    >
                        <svg v-if="align === 'left'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"></path></svg>
                        <svg v-if="align === 'center'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M4 18h16"></path></svg>
                        <svg v-if="align === 'right'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M4 18h16"></path></svg>
                        {{ align }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Line Specific Settings -->
        <div v-for="part in orderedKeys" :key="part" class="space-y-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-100 dark:border-gray-800">
            <div class="flex justify-between items-center">
                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase">{{ part }} LINE</span>
                <div class="flex gap-1 items-center">
                    <input 
                        type="color" 
                        :value="headerLines[part].color || '#000000'" 
                        @input="updateLine(part, 'color', $event.target.value)"
                        class="h-6 w-6 rounded border-0 p-0 bg-transparent cursor-pointer"
                    />
                    <button 
                        @click="updateLine(part, 'bold', !headerLines[part].bold)"
                        :class="headerLines[part].bold ? 'bg-blue-100 text-blue-600 border-blue-200' : 'bg-white text-gray-400 border-gray-200'"
                        class="p-1 px-2 border rounded text-xs font-bold transition-all"
                    >B</button>
                    <button 
                        @click="updateLine(part, 'italic', !headerLines[part].italic)"
                        :class="headerLines[part].italic ? 'bg-blue-100 text-blue-600 border-blue-200' : 'bg-white text-gray-400 border-gray-200 italic'"
                        class="p-1 px-2 border rounded text-xs font-medium transition-all"
                    >I</button>
                </div>
            </div>
            
            <textarea 
                :value="headerLines[part].text" 
                @input="updateLine(part, 'text', $event.target.value)"
                rows="1"
                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                :placeholder="`Enter ${part} line text...`"
            ></textarea>

            <div class="grid grid-cols-2 gap-2">
                <div class="flex items-center gap-2">
                    <label class="text-[10px] font-medium text-gray-400 uppercase">Size</label>
                    <div class="relative flex-1">
                        <button
                            type="button"
                            @click.stop="toggleDropdown(part)"
                            class="w-full h-7 pl-2 pr-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-[10px] text-left flex items-center justify-between focus:border-blue-500 focus:ring-blue-500 transition hover:bg-gray-50 dark:hover:bg-gray-600/80"
                        >
                            <span>{{ headerLines[part].fontSize }}px</span>
                            <svg class="w-2.5 h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Custom Dropdown Menu (Guaranteed Downward) -->
                        <div
                            v-if="openDropdown === part"
                            class="absolute left-0 right-0 mt-1 max-h-40 overflow-y-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-2xl z-50 no-scrollbar py-1"
                        >
                            <button
                                v-for="size in fontSizes"
                                :key="size"
                                type="button"
                                @click="updateLine(part, 'fontSize', size); openDropdown = null"
                                :class="[
                                    headerLines[part].fontSize === size
                                        ? 'bg-blue-600 text-white font-bold'
                                        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700',
                                    'w-full text-left px-2.5 py-1 text-[10px] transition'
                                ]"
                            >
                                {{ size }}px
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <select 
                        :value="headerLines[part].textTransform || 'none'"
                        @change="updateLine(part, 'textTransform', $event.target.value)"
                        class="w-full h-7 py-0 pl-2 pr-7 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-[10px] focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option v-for="t in transforms" :key="t.value" :value="t.value">{{ t.label }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>
