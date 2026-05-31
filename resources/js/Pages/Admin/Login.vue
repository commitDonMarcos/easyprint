<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const formErrors = computed(() => page.props.errors || {});

const form = useForm({
    password: ''
});

const login = () => {
    form.post(route('admin.login'));
};
</script>

<template>
    <Head title="Admin Login" />

    <div class="min-h-screen bg-slate-950 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:16px_24px] pointer-events-none"></div>
        
        <div class="relative w-full max-w-md">
            <div class="bg-[#1a2233] border border-slate-800 rounded-2xl p-8 shadow-2xl">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-extrabold text-white">Admin Access</h1>
                    <p class="text-slate-400 text-sm mt-2">Enter the admin password to continue</p>
                </div>

                <form @submit.prevent="login" class="space-y-6">
                    <div v-if="formErrors.password" class="bg-red-500/10 border border-red-500/30 rounded-lg p-3">
                        <p class="text-red-400 text-sm font-semibold">{{ formErrors.password }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-2">Password</label>
                        <input 
                            v-model="form.password"
                            type="password" 
                            required
                            class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                            placeholder="Enter admin password"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition disabled:opacity-50"
                    >
                        Sign In
                    </button>

                    <div class="text-center">
                        <a :href="route('dashboard')" class="text-sm text-slate-500 hover:text-slate-300 transition">
                            Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
