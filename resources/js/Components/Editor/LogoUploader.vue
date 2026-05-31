<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    slotId: String,
    currentLogo: String
});

const emit = defineEmits(['uploaded']);
const uploading = ref(false);
const error = ref(null);

const handleUpload = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    uploading.ref = true;
    error.value = null;

    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await axios.post(route('logos.upload'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        emit('uploaded', { slotId: props.slotId, url: response.data.url });
    } catch (err) {
        error.value = err.response?.data?.message || 'Upload failed';
    } finally {
        uploading.value = false;
    }
};
</script>

<template>
    <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Logo Slot: {{ slotId }}
        </label>
        
        <div class="flex items-center gap-4">
            <div v-if="currentLogo" class="w-16 h-16 bg-white border rounded p-1">
                <img :src="currentLogo" class="w-full h-full object-contain" />
            </div>
            <div v-else class="w-16 h-16 bg-gray-200 dark:bg-gray-700 border border-dashed rounded flex items-center justify-center text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>

            <div class="flex-1">
                <input 
                    type="file" 
                    @change="handleUpload" 
                    accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                />
                <p v-if="uploading" class="text-xs text-blue-600 mt-1">Uploading...</p>
                <p v-if="error" class="text-xs text-red-600 mt-1">{{ error }}</p>
            </div>
        </div>
    </div>
</template>
