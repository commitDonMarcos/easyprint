<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();
</script>

<template>
  <div class="min-h-screen bg-slate-950 text-[#e2e8f0] selection:bg-cyan-600 selection:text-white relative overflow-hidden font-sans transition-colors duration-500">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1400px] h-[800px] bg-gradient-radial from-cyan-500/10 via-transparent to-transparent blur-[160px] pointer-events-none"></div>
    <div class="absolute -top-[10%] -left-[10%] w-[500px] h-[500px] bg-cyan-500/10 blur-[130px] rounded-full pointer-events-none"></div>
    <div class="absolute top-[30%] -right-[10%] w-[600px] h-[600px] bg-indigo-600/10 blur-[150px] rounded-full pointer-events-none"></div>
    
    <nav class="sticky top-0 z-50 backdrop-blur-lg bg-slate-950/80 border-b border-slate-900/60 px-6 py-1">
      <div class="max-w-7xl mx-auto flex justify-between h-20 items-center">
        <div class="flex items-center gap-2">
          <svg class="w-8 h-8 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <span class="text-xl font-bold text-white">easyPrint</span>
        </div>
        <div class="flex items-center gap-6">
          <button @click="router.push('/dashboard')" class="relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-300 rounded-full bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 hover:shadow-[0_0_20px_rgba(6,182,212,0.4)] group overflow-hidden">
            <span class="relative z-10">Start Designing</span>
          </button>
        </div>
      </div>
    </nav>

    <section class="relative z-10 pt-6 pb-20 lg:py-24 overflow-hidden">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
        <div class="lg:col-span-5 text-left space-y-8 z-10">
          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900/60 border border-slate-800/80 text-cyan-400 text-xs font-bold uppercase tracking-wider">
            <span class="flex h-2 w-2 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
            </span>
            Next-Gen Header Publisher
          </div>
          <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.05] text-white">
            Professional <br />
            <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-500 bg-clip-text text-transparent">Document Headers</span> <br />
            in Seconds.
          </h1>
          <p class="text-lg text-slate-300/70 leading-relaxed max-w-xl">
            Skip the manual alignment struggles. Upload your logos, enter your lines of text, adjust dynamic vertical dividers, and instantly generate print-ready Word DOCX and vector PDF headers. No account needed.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 pt-2">
            <button @click="router.push('/dashboard')" class="bg-gradient-to-r from-cyan-500 to-indigo-600 text-white px-8 py-4 rounded-2xl text-base font-extrabold hover:shadow-[0_0_30px_rgba(6,182,212,0.45)] hover:scale-[1.02] transition duration-300 text-center flex items-center justify-center gap-2 group">
              Build Your Header Now
              <svg class="w-5 h-5 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
              </svg>
            </button>
          </div>
        </div>
        <div class="lg:col-span-7 relative h-[620px] w-full flex items-center justify-center mt-10 lg:mt-0 select-none">
          <div class="absolute w-[440px] h-[440px] rounded-full bg-gradient-to-br from-cyan-600/10 to-indigo-500/5 blur-3xl pointer-events-none animate-pulse-subtle z-0"></div>
          <div class="relative w-[340px] h-[460px] rounded-[32px] bg-white border border-slate-200 shadow-2xl p-5 flex flex-col justify-between z-20 transition duration-300 hover:scale-[1.02]">
            <div class="space-y-4">
              <div class="flex items-center justify-center text-blue-600 font-black text-lg tracking-tight">Header Preview</div>
              <div class="w-full bg-[#1e3a8a] text-white text-center py-1.5 px-3 rounded text-[6px] font-extrabold uppercase tracking-[3px]">Office of the Campus Director</div>
              <div class="space-y-2 pt-2">
                <div class="h-1 bg-slate-100 rounded-full w-full"></div>
                <div class="h-1 bg-slate-100 rounded-full w-full"></div>
                <div class="h-1 bg-slate-100 rounded-full w-[90%]"></div>
              </div>
            </div>
            <div class="border-t border-slate-100 pt-2 flex justify-between items-end">
              <div class="space-y-0.5">
                <div class="h-2 bg-slate-200 rounded w-24"></div>
                <div class="h-1 bg-slate-100 rounded w-16"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="py-12 border-t border-slate-900/60 text-center relative z-10">
      <p class="text-slate-500 text-xs tracking-wider uppercase font-bold">&copy; 2026 easyPrint. The ultimate document layout platform.</p>
    </footer>
  </div>
</template>

<style>
@keyframes pulseSubtle {
  0%, 100% { opacity: 0.95; transform: scale(1); }
  50% { opacity: 0.85; transform: scale(1.015); }
}
.animate-pulse-subtle { animation: pulseSubtle 4s ease-in-out infinite; }
.bg-gradient-radial { background-image: radial-gradient(var(--tw-gradient-stops)); }
</style>
