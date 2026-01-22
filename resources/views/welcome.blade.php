<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Manajemen Proyek SKPL</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'media',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Instrument Sans', 'Inter', 'sans-serif'],
                            },
                            colors: {
                                brand: {
                                    50: '#eff6ff',
                                    100: '#dbeafe',
                                    500: '#3b82f6',
                                    600: '#2563eb',
                                    900: '#1e3a8a',
                                }
                            },
                            animation: {
                                'float': 'float 6s ease-in-out infinite',
                                'float-delayed': 'float 6s ease-in-out 3s infinite',
                            },
                            keyframes: {
                                float: {
                                    '0%, 100%': { transform: 'translateY(0)' },
                                    '50%': { transform: 'translateY(-20px)' },
                                }
                            }
                        }
                    }
                }
            </script>
        @endif

        <style>
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
            .dark ::-webkit-scrollbar-thumb { background: #475569; }
            
            .bg-grid-pattern {
                background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
                background-size: 40px 40px;
            }
            .dark .bg-grid-pattern {
                background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            }
        </style>
    </head>
    <body class="antialiased bg-white text-slate-900 min-h-screen flex flex-col relative overflow-x-hidden font-sans selection:bg-blue-600 selection:text-white">
        
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-50 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-50 rounded-full blur-[120px]"></div>
            <div class="absolute inset-0 bg-grid-pattern opacity-[0.4] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
        </div>

        <nav class="w-full px-6 py-6 lg:px-12 flex justify-between items-center z-50 border-b-2 border-slate-100 bg-white/80 backdrop-blur-xl sticky top-0">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center shadow-xl group cursor-pointer hover:rotate-12 transition-all">
                    <img src="{{ asset('img/logo simpro.jpeg') }}" alt="Logo" class="h-8 w-auto object-contain rounded-lg">
                </div>
                <span class="font-black text-3xl tracking-tighter uppercase italic">SIM<span class="text-blue-600">PRO</span></span>
            </div>
            
            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3 rounded-2xl bg-slate-900 text-white font-black text-sm shadow-xl hover:-translate-y-1 transition-all uppercase tracking-widest">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative px-10 py-4 rounded-2xl bg-slate-900 text-white font-black text-sm shadow-2xl hover:shadow-blue-200 hover:-translate-y-1 transition-all duration-300 overflow-hidden uppercase tracking-[0.2em]">
                            <span class="relative z-10">Mulai Masuk</span>
                            <div class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    @endauth
                @endif
            </div>
        </nav>

        <main class="flex-grow flex flex-col lg:flex-row items-center justify-center px-6 lg:px-12 py-16 lg:py-24 gap-16 lg:gap-24 max-w-7xl mx-auto z-10">
            
            <div class="flex-1 text-center lg:text-left space-y-10 max-w-2xl">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-slate-900 text-white text-[10px] font-black tracking-[0.3em] uppercase mb-4 shadow-xl">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                    Enterprise Solutions v2.0
                </div>
                
                <h1 class="text-6xl lg:text-8xl font-black leading-[0.9] tracking-tighter uppercase italic text-slate-900">
                    DOMINASI <br>
                    <span class="text-blue-600 underline decoration-indigo-600 decoration-8 underline-offset-8">PROYEK</span> <br>
                    ANDA.
                </h1>
                
                <p class="text-xl text-slate-700 font-bold leading-relaxed max-w-xl">
                    Platform manajemen terpusat dengan performa tinggi. Rencanakan tugas, pantau efisiensi, dan <span class="text-slate-900 font-black italic">akselerasi output tim</span> secara real-time.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center lg:justify-start pt-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-12 py-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-lg shadow-2xl shadow-blue-200 hover:-translate-y-1.5 transition-all uppercase tracking-widest">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-12 py-5 rounded-2xl bg-slate-900 hover:bg-black text-white font-black text-lg shadow-2xl shadow-slate-300 hover:-translate-y-1.5 transition-all uppercase tracking-widest">
                            Mulai Sekarang
                        </a>
                    @endauth
                    
                    <a href="#features" class="px-12 py-5 rounded-2xl bg-white border-4 border-slate-900 text-slate-900 font-black text-lg hover:bg-slate-50 transition-all uppercase tracking-widest">
                        Fitur Utama
                    </a>
                </div>
            </div>

            <div class="flex-1 w-full max-w-xl relative flex items-center justify-center">
                <div class="absolute inset-0 bg-blue-600/5 rounded-full blur-[100px]"></div>
                
                <!-- Mockup UI -->
                <div class="relative w-full bg-white rounded-[40px] border-[10px] border-slate-900 shadow-[20px_20px_0px_0px_rgba(15,23,42,0.1)] p-8 z-20">
                    <div class="flex justify-between items-center mb-8 border-b-4 border-slate-50 pb-6">
                        <div class="flex flex-col gap-2">
                            <div class="h-3 w-32 bg-slate-100 rounded-full"></div>
                            <div class="h-8 w-48 bg-slate-900 rounded-xl"></div>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-black shadow-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="p-6 rounded-3xl bg-slate-50 border-2 border-slate-100">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">PROYEK AKTIF</div>
                            <div class="text-4xl font-black text-slate-900 tracking-tighter italic lowercase">12<span class="text-blue-600">.pts</span></div>
                        </div>
                        <div class="p-6 rounded-3xl bg-emerald-50 border-2 border-emerald-100">
                            <div class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">EFISIENSI</div>
                            <div class="text-4xl font-black text-emerald-900 tracking-tighter italic lowercase">85<span class="text-emerald-500">%</span></div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white border-2 border-slate-100 shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="h-4 w-3/4 bg-slate-900 rounded-full mb-2"></div>
                                <div class="h-2 w-1/2 bg-slate-200 rounded-full"></div>
                            </div>
                            <div class="text-[10px] font-black bg-blue-100 text-blue-700 px-3 py-1 rounded-full uppercase">FINAL</div>
                        </div>

                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white border-2 border-slate-100 shadow-sm opacity-50 translate-x-4">
                            <div class="w-8 h-8 rounded-lg bg-slate-200"></div>
                            <div class="flex-1">
                                <div class="h-4 w-2/3 bg-slate-900 rounded-full mb-2"></div>
                                <div class="h-2 w-1/3 bg-slate-200 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Badge -->
                <div class="absolute -right-8 bottom-20 w-56 bg-white p-6 rounded-[30px] border-4 border-slate-900 shadow-2xl z-30 animate-float">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 shadow-lg"></div>
                        <div>
                            <div class="h-2.5 w-24 bg-slate-800 rounded-full mb-1"></div>
                            <div class="h-2 w-12 bg-slate-200 rounded-full"></div>
                        </div>
                    </div>
                    <div class="h-3 w-full bg-slate-100 rounded-full mb-3 overflow-hidden border border-slate-200 p-0.5">
                        <div class="h-full w-[70%] bg-blue-600 rounded-full"></div>
                    </div>
                    <div class="text-[11px] font-black text-slate-900 text-right uppercase tracking-[0.2em]">70% DONE</div>
                </div>
            </div>
        </main>

        <section id="features" class="py-32 bg-slate-50 border-y-4 border-slate-900">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="text-center mb-24 space-y-4">
                    <h2 class="text-[11px] font-black text-blue-600 uppercase tracking-[0.5em] mb-4 italic">CORE CAPABILITIES</h2>
                    <h3 class="text-5xl lg:text-7xl font-black text-slate-900 uppercase tracking-tighter italic">ENGINEERED FOR <br><span class="text-slate-400">PERFECTION.</span></h3>
                </div>

                <div class="grid md:grid-cols-3 gap-12 text-black">
                    <div class="group p-10 rounded-[40px] bg-white border-4 border-slate-900 hover:shadow-[15px_15px_0px_0px_rgba(15,23,42,1)] transition-all duration-500 hover:-translate-y-4">
                        <div class="w-16 h-16 rounded-3xl bg-blue-100 flex items-center justify-center text-blue-600 mb-8 font-black text-2xl group-hover:rotate-12 transition-all">01</div>
                        <h4 class="text-2xl font-black mb-4 uppercase tracking-tight italic">Manajemen Proyek</h4>
                        <p class="text-slate-600 font-bold leading-relaxed">
                            Arsitektur data yang kuat untuk mengelola workspace proyek dengan kontrol penuh pada timeline dan resources.
                        </p>
                    </div>

                    <div class="group p-10 rounded-[40px] bg-white border-4 border-slate-900 hover:shadow-[15px_15px_0px_0px_rgba(37,99,235,1)] transition-all duration-500 hover:-translate-y-4 border-blue-600">
                        <div class="w-16 h-16 rounded-3xl bg-slate-900 flex items-center justify-center text-white mb-8 font-black text-2xl group-hover:rotate-12 transition-all">02</div>
                        <h4 class="text-2xl font-black mb-4 uppercase tracking-tight italic">Status Real-Time</h4>
                        <p class="text-slate-600 font-bold leading-relaxed">
                            Visualisasi progress dengan akurasi tinggi. Lacak setiap tugas dari inisiasi hingga tahap penyelesaian akhir.
                        </p>
                    </div>

                    <div class="group p-10 rounded-[40px] bg-white border-4 border-slate-900 hover:shadow-[15px_15px_0px_0px_rgba(15,23,42,1)] transition-all duration-500 hover:-translate-y-4 text-black">
                        <div class="w-16 h-16 rounded-3xl bg-indigo-100 flex items-center justify-center text-indigo-600 mb-8 font-black text-2xl group-hover:rotate-12 transition-all">03</div>
                        <h4 class="text-2xl font-black mb-4 uppercase tracking-tight italic">Kolaborasi Ekstrim</h4>
                        <p class="text-slate-600 font-bold leading-relaxed">
                            Fitur komunikasi terintegrasi yang memungkinkan tim berinteraksi lebih cepat dan meminimalisir miskomunikasi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-12 bg-white text-center border-t-2 border-slate-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-4">
                    <span class="font-black text-2xl tracking-tighter uppercase italic">SIMPRO<span class="text-blue-600">.SYSTEM</span></span>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">
                    &copy; {{ date('Y') }} Enterprise Grade Project Management. Built with Laravel.
                </p>
                <div class="flex gap-4">
                    <div class="w-10 h-10 bg-slate-50 rounded-xl border-2 border-slate-100 flex items-center justify-center text-slate-400 font-black">TW</div>
                    <div class="w-10 h-10 bg-slate-50 rounded-xl border-2 border-slate-100 flex items-center justify-center text-slate-400 font-black">FB</div>
                </div>
            </div>
        </footer>
    </body>
</html>