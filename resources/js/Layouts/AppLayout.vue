<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <div class="min-h-screen bg-slate-900 dark:bg-[#0b1329] text-gray-100">
            <nav class="border-b border-[#2d3748] bg-[#1a2233]">
                <div class="w-full px-6">
                    <div class="flex h-20 justify-between items-center">
                        <div class="flex items-center h-full w-full md:w-1/3 md:min-w-[360px] md:max-w-[420px] md:flex-shrink-0">
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current animate-pulse-subtle" />
                                </Link>
                            </div>
                        </div>

                        <div class="flex-1 flex justify-between items-center h-full px-0">
                            <div class="hidden space-x-8 sm:-my-px sm:flex items-center h-full">
                                <Link 
                                    :href="route('dashboard')" 
                                    class="h-full flex items-center pt-1 text-sm font-semibold text-gray-400 hover:text-white transition"
                                >
                                    Dashboard
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <header
                class="bg-transparent"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
