<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

const last7Days = computed(() => props.stats.dailyStats?.slice(0, 7) || []);
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Analytics Dashboard</h2>
                    <p class="text-slate-400 mt-1 text-sm">Real-time usage analytics and template performance tracking.</p>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-[#1e293b] rounded-2xl p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
                        <div class="absolute right-4 top-4 text-slate-700/30 group-hover:text-slate-700/50 transition">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                        </div>
                        <div class="text-slate-400 text-sm font-semibold tracking-wider uppercase">Total Visitors</div>
                        <div class="text-4xl font-extrabold text-white mt-2">{{ stats.totalVisitors }}</div>
                        <div class="text-xs text-slate-500 mt-2">Unique browser sessions</div>
                    </div>

                    <div class="bg-[#1e293b] rounded-2xl p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
                        <div class="absolute right-4 top-4 text-indigo-500/20 group-hover:text-indigo-500/30 transition">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                        </div>
                        <div class="text-slate-400 text-sm font-semibold tracking-wider uppercase">Template Selections</div>
                        <div class="text-4xl font-extrabold text-indigo-400 mt-2">{{ stats.totalTemplateSelections }}</div>
                        <div class="text-xs text-slate-500 mt-2">Projects created from templates</div>
                    </div>

                    <div class="bg-[#1e293b] rounded-2xl p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
                        <div class="absolute right-4 top-4 text-blue-500/20 group-hover:text-blue-500/30 transition">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                        </div>
                        <div class="text-slate-400 text-sm font-semibold tracking-wider uppercase">DOCX Exports</div>
                        <div class="text-4xl font-extrabold text-blue-400 mt-2">{{ stats.totalDocxExports }}</div>
                        <div class="text-xs text-slate-500 mt-2">Word documents exported</div>
                    </div>

                    <div class="bg-[#1e293b] rounded-2xl p-6 border border-slate-800 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
                        <div class="absolute right-4 top-4 text-red-500/20 group-hover:text-red-500/30 transition">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                        </div>
                        <div class="text-slate-400 text-sm font-semibold tracking-wider uppercase">PDF Exports</div>
                        <div class="text-4xl font-extrabold text-red-400 mt-2">{{ stats.totalPdfExports }}</div>
                        <div class="text-xs text-slate-500 mt-2">PDF documents exported</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-[#1e293b] rounded-2xl border border-slate-800 shadow-xl overflow-hidden lg:col-span-2">
                        <div class="p-6 border-b border-slate-800 bg-[#161f30]">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Template Popularity
                            </h3>
                            <p class="text-xs text-slate-400 mt-1">Most used templates by selection count.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-800 text-xs font-bold text-slate-400 uppercase bg-slate-900/40">
                                        <th class="px-6 py-4">Rank</th>
                                        <th class="px-6 py-4">Template</th>
                                        <th class="px-6 py-4 text-center">Selections</th>
                                        <th class="px-6 py-4 text-center">DOCX</th>
                                        <th class="px-6 py-4 text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800 text-sm">
                                    <tr v-for="(template, index) in stats.mostUsedTemplates" :key="template.id" class="hover:bg-slate-900/20 transition">
                                        <td class="px-6 py-4 font-bold text-slate-400">#{{ index + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-white">{{ template.name }}</div>
                                            <div class="text-xs text-slate-500 font-mono">{{ template.slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center font-extrabold text-indigo-400">{{ template.selection_count }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-blue-400">{{ template.docx_export_count }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-red-400">{{ template.pdf_export_count }}</td>
                                    </tr>
                                    <tr v-if="stats.mostUsedTemplates.length === 0">
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                            No usage data yet.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-[#1e293b] rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
                        <div class="p-6 border-b border-slate-800 bg-[#161f30]">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"></path></svg>
                                Daily Stats (Last 7 Days)
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div v-for="day in last7Days" :key="day.date" class="space-y-2">
                                <div class="flex justify-between text-xs text-slate-400">
                                    <span class="font-semibold">{{ day.date }}</span>
                                    <span>{{ day.visits }} visits</span>
                                </div>
                                <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                                    <div class="bg-indigo-500 h-full rounded-full" 
                                         :style="{ width: Math.min(100, (day.visits / Math.max(...last7Days.map(d => d.visits), 1)) * 100) + '%' }">
                                    </div>
                                </div>
                            </div>
                            <div v-if="last7Days.length === 0" class="text-center text-slate-500 text-sm py-8">
                                No data for the last 7 days.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-slate-600 text-center">
                    {{ stats.totalProjects }} total projects created &middot; Data updates in real-time
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
