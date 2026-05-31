<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <Head title="Professional Document Headers in Seconds" />
    
    <div class="min-h-screen bg-slate-950 text-[#e2e8f0] selection:bg-cyan-600 selection:text-white relative overflow-hidden font-sans transition-colors duration-500">
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1400px] h-[800px] bg-gradient-radial from-cyan-500/10 via-transparent to-transparent blur-[160px] pointer-events-none"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[500px] h-[500px] bg-cyan-500/10 blur-[130px] rounded-full pointer-events-none"></div>
        <div class="absolute top-[30%] -right-[10%] w-[600px] h-[600px] bg-indigo-600/10 blur-[150px] rounded-full pointer-events-none"></div>
        <div class="absolute top-[60%] -left-[10%] w-[500px] h-[500px] bg-purple-600/5 blur-[140px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 right-[10%] w-[500px] h-[500px] bg-cyan-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:16px_24px] pointer-events-none [mask-image:radial-gradient(ellipse_60%_50%_at_50%_40%,#000_70%,transparent_100%)]"></div>

        <nav class="sticky top-0 z-50 backdrop-blur-lg bg-slate-950/80 border-b border-slate-900/60 px-6 py-1">
            <div class="max-w-7xl mx-auto flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <ApplicationLogo />
                </div>
                <div class="flex items-center gap-6">
                    <Link 
                        :href="route('dashboard')" 
                        class="relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-300 rounded-full bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 hover:shadow-[0_0_20px_rgba(6,182,212,0.4)] group overflow-hidden"
                    >
                        <span class="relative z-10">Start Designing</span>
                    </Link>
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
                        <Link 
                            :href="route('dashboard')" 
                            class="bg-gradient-to-r from-cyan-500 to-indigo-600 text-white px-8 py-4 rounded-2xl text-base font-extrabold hover:shadow-[0_0_30px_rgba(6,182,212,0.45)] hover:scale-[1.02] transition duration-300 text-center flex items-center justify-center gap-2 group"
                        >
                            Build Your Header Now
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </Link>
                        <a 
                            href="#features" 
                            class="bg-slate-900/40 text-white px-8 py-4 rounded-2xl text-base font-bold border border-slate-800/80 hover:border-slate-600 hover:bg-slate-900/60 hover:scale-[1.02] transition duration-300 text-center flex items-center justify-center"
                        >
                            See Features
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-7 relative h-[620px] w-full flex items-center justify-center mt-10 lg:mt-0 select-none">
                    
                    <div class="absolute w-[440px] h-[440px] rounded-full bg-gradient-to-br from-cyan-600/10 to-indigo-500/5 blur-3xl pointer-events-none animate-pulse-subtle z-0"></div>

                    <div class="relative w-[340px] h-[460px] rounded-[32px] bg-white border border-slate-200 shadow-2xl p-5 flex flex-col justify-between z-20 transition duration-300 hover:scale-[1.02]">
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-[1fr_auto_1fr] w-full items-center gap-2 border-b border-slate-100 pb-2">
                                <div class="flex items-center gap-1">
                                    <svg class="w-7 h-7 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm0 10.99h6c-.53 4.12-3.28 7.79-6 8.94V13h-6V6.39l6-2.25v8.85z"/>
                                    </svg>
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                                    </svg>
                                    
                                    <div class="h-6 w-0.5 bg-blue-600 ml-1"></div>
                                    <div class="h-6 w-1 bg-blue-600"></div>
                                </div>
                                <div class="text-center space-y-0.5 min-w-0">
                                    <h5 class="text-[5px] font-semibold text-slate-405 uppercase tracking-widest leading-none">Republic of the Philippines</h5>
                                    <h3 class="text-[7px] font-black text-blue-900 uppercase tracking-tight leading-tight">State Science University</h3>
                                    <h5 class="text-[5px] font-semibold text-slate-500 uppercase tracking-widest leading-none">Main Campus, Manila</h5>
                                </div>
                                <div class="flex justify-end">
                                    <svg class="w-7 h-7 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3.19L5 6.3v4.61c0 4.19 2.97 8.1 7 9.09 4.03-.99 7-4.9 7-9.09V6.3l-7-3.11zm1.5 12.81c-.55 0-1-.45-1-1v-2h-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-5c0-.55.45-1 1-1s1 .45 1 1v1h2v-1c0-.55.45-1 1-1s1 .45 1 1v5c0 .55-.45 1-1 1z"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="w-full bg-[#1e3a8a] text-white text-center py-1.5 px-3 rounded text-[6px] font-extrabold uppercase tracking-[3px] leading-none">
                                Office of the Campus Director
                            </div>

                            <div class="space-y-2 pt-2">
                                <div class="flex justify-between items-center text-[5px] font-bold text-slate-400 border-b border-slate-100 pb-1">
                                    <span>MEMORANDUM NO. 2026-084</span>
                                    <span>May 18, 2026</span>
                                </div>
                                <div class="space-y-1.5 pt-1">
                                    <div class="h-1 bg-slate-100 rounded-full w-full"></div>
                                    <div class="h-1 bg-slate-100 rounded-full w-full"></div>
                                    <div class="h-1 bg-slate-100 rounded-full w-[90%]"></div>
                                    <div class="h-1 bg-slate-100 rounded-full w-full pt-1"></div>
                                    <div class="h-1 bg-slate-100 rounded-full w-[40%]"></div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-2 flex justify-between items-end">
                            <div class="space-y-0.5">
                                <h6 class="text-[5px] font-extrabold text-slate-800 leading-none">DR. ARMANDO R. VALENZUELA</h6>
                                <p class="text-[4px] font-medium text-slate-400 leading-none">Campus Director & Dean</p>
                            </div>
                            <div class="w-6 h-6 rounded-full border border-blue-500/30 flex items-center justify-center text-[4px] font-bold text-blue-500 rotate-12">
                                SEAL
                            </div>
                        </div>

                    </div>

                    <div class="absolute top-2 right-12 w-[210px] h-[300px] rounded-[24px] bg-white border border-slate-200/90 shadow-2xl p-4 flex flex-col justify-between z-10 hover:z-30 hover:scale-105 hover:rotate-1 rotate-2 transition duration-300">
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-1.5 gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                                <div class="text-center min-w-0">
                                    <h3 class="text-[6px] font-black text-slate-800 uppercase tracking-tight leading-none">Global Tech Inc.</h3>
                                    <h5 class="text-[4px] font-semibold text-slate-400 uppercase tracking-wider leading-none">Research & Development Sector</h5>
                                </div>
                                <svg class="w-5 h-5 text-cyan-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                                </svg>
                            </div>

                            <div class="space-y-0.5">
                                <div class="h-0.5 bg-slate-900 w-full"></div>
                                <div class="h-[1px] bg-slate-500 w-full"></div>
                            </div>

                            <div class="space-y-1.5 pt-1">
                                <div class="h-0.5 bg-slate-100 rounded-full w-full"></div>
                                <div class="h-0.5 bg-slate-100 rounded-full w-full"></div>
                                <div class="h-0.5 bg-slate-100 rounded-full w-[80%]"></div>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-1.5">
                            <h6 class="text-[4px] font-bold text-slate-700 leading-none">STEVE G. HARRISON</h6>
                            <p class="text-[3px] text-slate-400 leading-none">Chief Executive Officer</p>
                        </div>

                    </div>

                    <div class="absolute bottom-6 left-6 w-[220px] h-[310px] rounded-[24px] bg-white border border-slate-200/90 shadow-2xl p-4 flex flex-col justify-between z-10 hover:z-30 hover:scale-105 hover:-rotate-1 -rotate-2 transition duration-300">
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-1.5 gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <div class="text-center min-w-0">
                                    <h3 class="text-[6px] font-black text-blue-900 uppercase tracking-tight leading-none">Department of Education</h3>
                                    <h5 class="text-[4px] font-semibold text-slate-400 uppercase tracking-wider leading-none">Region III - Central Luzon</h5>
                                </div>
                                <div class="w-5"></div>
                            </div>

                            <div class="h-[1px] bg-blue-900 w-full"></div>

                            <div class="space-y-1.5 pt-1">
                                <div class="h-0.5 bg-slate-100 rounded-full w-full"></div>
                                <div class="h-0.5 bg-slate-100 rounded-full w-full"></div>
                                <div class="h-0.5 bg-slate-100 rounded-full w-[85%]"></div>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-1.5">
                            <h6 class="text-[4px] font-bold text-slate-700 leading-none">MARIA K. SANTO</h6>
                            <p class="text-[3px] text-slate-400 leading-none">Regional Director</p>
                        </div>

                    </div>

                    <div class="absolute top-8 left-[18%] z-30 bg-[#151f32]/95 text-white rounded-[20px] px-6 py-4 shadow-[0_20px_50px_rgba(0,0,0,0.45)] flex flex-col gap-1 min-w-[210px] border border-slate-800 hover:scale-105 transition duration-300">
                        <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest leading-none">Active Template</span>
                        <span class="text-base font-black text-white tracking-tight flex items-center gap-2">
                            <span class="flex h-2.5 w-2.5 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-cyan-500"></span>
                            </span>
                            Symmetrical Layout 1
                        </span>
                    </div>

                    <div class="absolute top-[24%] left-2 z-10 bg-[#070e1b]/95 backdrop-blur-md border border-slate-800 rounded-2xl p-4 shadow-[0_15px_30px_rgba(0,0,0,0.35)] font-mono text-[9px] text-cyan-400 min-w-[170px] leading-relaxed select-none hover:scale-105 transition duration-300">
                        <div class="flex gap-1.5 mb-2.5 border-b border-slate-800/80 pb-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500/80"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500/80"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500/80"></span>
                            <span class="text-[8px] text-slate-500 font-semibold uppercase ml-1">easyprint.js</span>
                        </div>
                        <div class="space-y-0.5 text-slate-300">
                            <span class="text-slate-600">1</span> <span class="text-indigo-400">import</span> { easyPrint } <span class="text-indigo-400">from</span> <span class="text-cyan-300">'core'</span>;<br>
                            <span class="text-slate-600">2</span> <br>
                            <span class="text-slate-600">3</span> <span class="text-indigo-400">const</span> header = easyPrint({<br>
                            <span class="text-slate-600">4</span> &nbsp;&nbsp;layout: <span class="text-cyan-300">'symmetrical'</span>,<br>
                            <span class="text-slate-600">5</span> &nbsp;&nbsp;logos: <span class="text-slate-300">2</span>,<br>
                            <span class="text-slate-600">6</span> &nbsp;&nbsp;divider: <span class="text-cyan-300">'thin-thick'</span><br>
                            <span class="text-slate-600">7</span> });
                        </div>
                    </div>

                    <div class="absolute bottom-[38%] left-0 z-30 bg-[#151f32]/95 text-white rounded-full px-5 py-3 shadow-[0_20px_40px_rgba(0,0,0,0.35)] flex items-center gap-2.5 border border-slate-800 hover:scale-105 transition duration-300">
                        <div class="w-5.5 h-5.5 rounded-full bg-cyan-500 flex items-center justify-center text-white">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-xs font-black text-white tracking-tight">Word DOCX Exported!</span>
                    </div>

                    <div class="absolute bottom-6 right-8 z-30 bg-[#151f32]/95 text-white rounded-3xl p-5 shadow-[0_25px_60px_rgba(0,0,0,0.45)] min-w-[250px] border border-slate-800 hover:scale-105 transition duration-300">
                        <h4 class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-4">Export Formats</h4>
                        <div class="space-y-3.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-extrabold text-slate-100 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-cyan-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4 10h-2v2h-2v-2H9v-2h2V9h2v2h2v2z"/></svg>
                                    Word Document (.docx)
                                </span>
                                <span class="text-[9px] font-bold text-cyan-400 bg-cyan-950 px-2.5 py-0.5 rounded-full">Perfect</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-extrabold text-slate-100 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V8H10c.83 0 1.5.67 1.5 1.5v2zm-7-2h1v1h-1v-1zm4.5 2H15v-1.5h-1v1.5z"/></svg>
                                    Adobe PDF (.pdf)
                                </span>
                                <span class="text-[9px] font-bold text-cyan-400 bg-cyan-950 px-2.5 py-0.5 rounded-full">Vector</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-extrabold text-slate-100 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                    High-Res Image (.png)
                                </span>
                                <span class="text-[9px] font-bold text-cyan-400 bg-cyan-950 px-2.5 py-0.5 rounded-full">Raster</span>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-2 left-[34%] z-30 bg-[#070e1b]/95 backdrop-blur-md border border-slate-800 rounded-2xl p-4 shadow-[0_15px_40px_rgba(0,0,0,0.3)] min-w-[130px] hover:scale-105 transition duration-300">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[8px] font-extrabold text-cyan-400 uppercase tracking-wider">Precision ↑</span>
                            <span class="text-[10px] font-black text-white">100%</span>
                        </div>
                        <div class="h-6 flex items-end">
                            <svg class="w-full h-full text-cyan-400" viewBox="0 0 100 30" fill="none" preserveAspectRatio="none">
                                <path d="M0 25 C15 22, 30 5, 45 12 C60 18, 75 2, 100 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M0 25 C15 22, 30 5, 45 12 C60 18, 75 2, 100 4 L100 30 L0 30 Z" fill="url(#wave-grad)" opacity="0.12"/>
                                <defs>
                                    <linearGradient id="wave-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" stop-color="currentColor"/>
                                        <stop offset="100%" stop-color="transparent"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section id="features" class="py-24 bg-transparent border-t border-slate-900/60 relative z-10">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-950/80 pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                    <span class="text-cyan-400 text-xs font-extrabold uppercase tracking-widest">Built for Perfection</span>
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight">Why document designers love EasyPrint</h2>
                    <p class="text-base text-slate-400">Say goodbye to manual margins, broken alignments, and ugly stretched images inside Word.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-10">
                    <div class="p-8 rounded-3xl bg-slate-900/40 backdrop-blur-sm border border-slate-800/60 hover:border-slate-700/80 transition duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 bg-cyan-950/30 rounded-2xl flex items-center justify-center text-cyan-400 border border-cyan-900/40 mb-6 group-hover:scale-110 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-white mb-3">Absolute Symmetrical Grid</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">Our modern rendering grid balances left and right logo sizes, locking your school text to the horizontal center of the sheet.</p>
                    </div>

                    <div class="p-8 rounded-3xl bg-slate-900/40 backdrop-blur-sm border border-slate-800/60 hover:border-slate-700/80 transition duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 bg-cyan-950/30 rounded-2xl flex items-center justify-center text-cyan-400 border border-cyan-900/40 mb-6 group-hover:scale-110 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-white mb-3">Smart Typographic Scaling</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">Long university names are dynamically scaled inside Word to ensure they fit cleanly on a single line without manual editing.</p>
                    </div>

                    <div class="p-8 rounded-3xl bg-slate-900/40 backdrop-blur-sm border border-slate-800/60 hover:border-slate-700/80 transition duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 bg-cyan-950/30 rounded-2xl flex items-center justify-center text-cyan-400 border border-cyan-900/40 mb-6 group-hover:scale-110 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-white mb-3">Pixel-Perfect Word DOCX</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">Exported Word files use Microsoft XML Twips parameters, guaranteeing that your live screen design looks identical on print.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 relative z-10 overflow-hidden bg-transparent border-t border-slate-900/60 text-center px-6">
            <div class="max-w-4xl mx-auto space-y-8 relative z-10">
                <h2 class="text-4xl md:text-6xl font-black tracking-tight leading-tight">Ready to build elegant, print-ready document headers?</h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto">No account required. Start designing instantly.</p>
                <div class="pt-4">
                    <Link 
                        :href="route('dashboard')" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-indigo-600 text-white px-10 py-5 rounded-2xl text-lg font-black hover:shadow-[0_0_40px_rgba(6,182,212,0.5)] hover:scale-[1.02] transition duration-300"
                    >
                        Start Designing Free
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </Link>
                </div>
            </div>
        </section>

        <footer class="py-12 border-t border-slate-900/60 text-center relative z-10 bg-transparent">
            <p class="text-slate-500 text-xs tracking-wider uppercase font-bold">&copy; 2026 easyPrint. The ultimate document layout platform. Built for speed and precision.</p>
        </footer>
    </div>
</template>

<style>
@keyframes pulseSubtle {
    0%, 100% { opacity: 0.95; transform: scale(1); }
    50% { opacity: 0.85; transform: scale(1.015); }
}
.animate-pulse-subtle {
    animation: pulseSubtle 4s ease-in-out infinite;
}
.bg-gradient-radial {
    background-image: radial-gradient(var(--tw-gradient-stops));
}
.font-sans {
    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
</style>
