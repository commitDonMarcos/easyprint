<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, useForm } from '@inertiajs/vue3';

const isSidebarOpen = ref(true);
const logoutForm = useForm({});

const logout = () => {
    logoutForm.post(route('admin.logout'));
};
</script>

<template>
    <div class="min-h-screen bg-[#0b1329] text-gray-100 flex font-sans antialiased">
        
        <aside 
            :class="[
                isSidebarOpen ? 'w-64' : 'w-20',
                'bg-[#131d35] border-r border-[#263554] flex flex-col justify-between transition-all duration-300 ease-in-out fixed inset-y-0 left-0 z-40'
            ]"
        >
            <div>
                <div class="h-20 flex items-center px-4 border-b border-[#263554]/50 justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <Link :href="route('admin.dashboard')" class="flex-shrink-0 flex items-center justify-center">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-indigo-600 shadow-md shadow-cyan-500/20 flex items-center justify-center hover:scale-105 transition-transform">
                                <svg class="text-white w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </div>
                        </Link>
                        <div v-if="isSidebarOpen" class="flex flex-col whitespace-nowrap animate-fade-in">
                            <span class="text-base font-extrabold text-white tracking-tight leading-none">
                                Easy<span class="bg-gradient-to-r from-cyan-400 to-indigo-400 bg-clip-text text-transparent font-black">Print</span>
                            </span>
                            <span class="text-[9px] font-bold text-yellow-400 uppercase tracking-widest mt-1">[Analytics]</span>
                        </div>
                    </div>
                    
                    <button 
                        @click="isSidebarOpen = !isSidebarOpen"
                        class="text-gray-400 hover:text-white hover:bg-slate-800/50 p-1.5 rounded-lg transition-colors hidden md:block"
                    >
                        <svg 
                            class="w-5 h-5 transition-transform duration-300" 
                            :class="{ 'rotate-180': !isSidebarOpen }" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                <nav class="p-4 space-y-2.5">
                    <Link
                        :href="route('admin.dashboard')"
                        :class="[
                            route().current('admin.dashboard')
                                ? 'bg-indigo-600 text-white font-bold shadow-md shadow-indigo-600/20'
                                : 'text-gray-400 hover:text-white hover:bg-[#1a294d]/40',
                            'flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 group relative'
                        ]"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span v-if="isSidebarOpen" class="text-sm font-medium tracking-wide">Dashboard</span>
                        <span v-if="!isSidebarOpen" class="absolute left-24 bg-[#131d35] border border-[#263554] text-white text-xs font-semibold px-2 py-1.5 rounded-lg opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all pointer-events-none whitespace-nowrap shadow-xl">
                            Dashboard
                        </span>
                    </Link>
                </nav>
            </div>

            <div class="p-4 border-t border-[#263554]/50">
                <Link 
                    :href="route('dashboard')"
                    class="flex items-center gap-3.5 px-4 py-2.5 mb-4 text-gray-400 hover:text-white hover:bg-[#1a294d]/40 rounded-xl transition group relative"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span v-if="isSidebarOpen" class="text-xs font-semibold tracking-wide">Back to App</span>
                    <span v-if="!isSidebarOpen" class="absolute left-24 bg-[#131d35] border border-[#263554] text-white text-xs font-semibold px-2 py-1.5 rounded-lg opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all pointer-events-none whitespace-nowrap shadow-xl">
                        Back to App
                    </span>
                </Link>

                <button
                    @click="logout"
                    class="w-full flex items-center gap-3.5 px-4 py-2.5 text-gray-400 hover:text-white hover:bg-[#1a294d]/40 rounded-xl transition group relative"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span v-if="isSidebarOpen" class="text-xs font-semibold tracking-wide">Logout</span>
                    <span v-if="!isSidebarOpen" class="absolute left-24 bg-[#131d35] border border-[#263554] text-white text-xs font-semibold px-2 py-1.5 rounded-lg opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all pointer-events-none whitespace-nowrap shadow-xl">
                        Logout
                    </span>
                </button>
            </div>
        </aside>

        <div 
            :class="[
                isSidebarOpen ? 'pl-64' : 'pl-20',
                'flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out'
            ]"
        >
            <header class="h-20 bg-[#131d35]/65 backdrop-blur-md border-b border-[#263554]/50 flex items-center px-8 z-35 sticky top-0" v-if="$slots.header">
                <div class="w-full max-w-7xl mx-auto">
                    <slot name="header" />
                </div>
            </header>

            <main class="flex-1 p-8">
                <slot />
            </main>
        </div>

    </div>
</template>

<style scoped>
.animate-pulse-subtle {
    animation: pulse-subtle 2s infinite ease-in-out;
}
@keyframes pulse-subtle {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .85; transform: scale(0.98); }
}
.animate-fade-in {
    animation: fadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateX(-4px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>
