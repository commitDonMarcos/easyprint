import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),
    },
  },
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          pdf: ['jspdf', 'html2canvas'],
          vendor: ['vue', 'vue-router', 'axios'],
        },
      },
    },
    chunkSizeWarningLimit: 1000,
  },
});
