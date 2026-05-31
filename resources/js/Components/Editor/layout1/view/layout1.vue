<script setup>
import { computed } from 'vue';

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

const getLogoUrl = (slot) => {
    return props.settings.logos?.[slot] || null;
};

const CANONICAL_ORDER = ['top', 'middle', 'bottom'];
const orderedLineKeys = computed(() => {
    const existing = Object.keys(props.settings.headerLines ?? {});
    return [
        ...CANONICAL_ORDER.filter(k => existing.includes(k)),
        ...existing.filter(k => !CANONICAL_ORDER.includes(k)),
    ];
});
</script>

<template>
    <div 
        class="bg-white mx-auto overflow-hidden print:m-0"
        :style="{ 
            padding: `${settings.margin}px`,
            paddingTop: `${settings.headerTop}px`,
            fontFamily: settings.fontFamily,
            color: settings.textColor || '#000'
        }"
    >
        <div 
            class="grid w-full items-center gap-4"
            :style="{ gridTemplateColumns: 'minmax(max-content, 1fr) auto minmax(max-content, 1fr)' }"
        >
            <!-- Left Slot (1 logo) -->
            <div class="flex justify-start gap-4 items-center flex-shrink-0">
                <template v-for="(type, index) in template?.json_structure?.slots?.left" :key="'left-' + index">
                    <img 
                        v-if="getLogoUrl('left_' + index)" 
                        :src="getLogoUrl('left_' + index)" 
                        :style="{ height: `${settings.logoSize ?? 80}px` }"
                        class="w-auto object-contain flex-shrink-0" 
                        alt="Left Logo"
                    />
                </template>
            </div>

            <!-- Center Slot (Text) -->
            <div 
                class="px-2 flex flex-col justify-center min-w-0"
                :class="[
                    settings.textAlign === 'left' ? 'text-left items-start' :
                    settings.textAlign === 'right' ? 'text-right items-end' :
                    'text-center items-center'
                ]"
            >
                <div 
                    v-for="part in orderedLineKeys" 
                    :key="part"
                    :style="{ 
                        fontSize: `${settings.headerLines[part].fontSize}pt`, 
                        fontWeight: settings.headerLines[part].bold ? 'bold' : 'normal',
                        fontStyle: settings.headerLines[part].italic ? 'italic' : 'normal',
                        textTransform: settings.headerLines[part].textTransform || 'none',
                        color: settings.headerLines[part].color || '#000000',
                        letterSpacing: `${settings.letterSpacing}px`,
                        lineHeight: settings.lineHeight || 1.2
                    }"
                    class="whitespace-pre-wrap"
                >
                    {{ settings.headerLines[part].text }}
                </div>
            </div>

            <!-- Right Slot (1 logo) -->
            <div class="flex justify-end gap-4 items-center flex-shrink-0">
                <template v-for="(type, index) in template?.json_structure?.slots?.right" :key="'right-' + index">
                    <img 
                        v-if="getLogoUrl('right_' + index)" 
                        :src="getLogoUrl('right_' + index)" 
                        :style="{ height: `${settings.logoSize ?? 80}px` }"
                        class="w-auto object-contain flex-shrink-0" 
                        alt="Right Logo"
                    />
                </template>
            </div>
        </div>

        <!-- Horizontal Divider -->
        <div 
            v-if="settings.divider?.enabled"
            :style="{ 
                height: settings.divider.text ? 'auto' : `${settings.divider.thickness}px`,
                minHeight: `${settings.divider.thickness}px`,
                backgroundColor: settings.divider.color,
                marginTop: `${settings.divider.top}px`,
                paddingTop: settings.divider.text ? `${settings.divider.padding ?? 8}px` : '0px',
                paddingBottom: settings.divider.text ? `${settings.divider.padding ?? 8}px` : '0px',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center'
            }"
            class="w-full transition-all overflow-hidden"
        >
            <span 
                v-if="settings.divider.text"
                :style="{
                    color: settings.divider.textColor || '#ffffff',
                    fontSize: `${settings.divider.fontSize ?? 10}pt`,
                    fontWeight: (settings.divider.bold ?? true) ? 'bold' : 'normal',
                    fontStyle: (settings.divider.italic ?? false) ? 'italic' : 'normal',
                    letterSpacing: `${settings.divider.letterSpacing ?? 3}px`
                }"
                class="uppercase px-4 leading-none inline-flex items-center justify-center h-full text-center"
            >
                {{ settings.divider.text }}
            </span>
        </div>
    </div>
</template>
