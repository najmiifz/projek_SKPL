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
    <body class="antialiased bg-gray-50 dark:bg-[#0a0a0a] text-gray-900 dark:text-gray-100 min-h-screen flex flex-col relative overflow-x-hidden font-sans">
        
        <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-400/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-400/20 rounded-full blur-[120px]"></div>
            <div class="absolute inset-0 bg-grid-pattern [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
        </div>

        <nav class="w-full px-6 py-4 lg:px-12 flex justify-between items-center z-50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo simpro.jpeg') }}" alt="Logo" class="h-12 w-auto object-contain rounded-md shadow-sm">
                <span class="font-bold text-2xl tracking-tighter">SIM<span class="text-blue-600 dark:text-blue-400">PRO</span></span>
            </div>
            
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-full bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 transition font-medium text-sm shadow-sm backdrop-blur-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative px-6 py-2.5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold text-sm shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                            <span class="relative z-10">Masuk / Login</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 dark:hidden"></div>
                        </a>
                    @endauth
                @endif
            </div>
        </nav>

        <main class="flex-grow flex flex-col lg:flex-row items-center justify-center px-6 lg:px-12 py-12 lg:py-20 gap-12 lg:gap-20 max-w-7xl mx-auto z-10">
            
            <div class="flex-1 text-center lg:text-left space-y-8 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 text-blue-600 dark:text-blue-400 text-xs font-semibold tracking-wide uppercase mb-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Sistem Manajemen Proyek
                </div>
                
                <h1 class="text-4xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Kelola Proyek & Tim <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Lebih Efisien.</span>
                </h1>
                
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                    Platform terpusat untuk merencanakan tugas, memantau progres, dan berkolaborasi dengan tim pengembang secara <i>real-time</i>.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-1">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-1">
                            Mulai Sekarang
                        </a>
                    @endauth
                    
                    <a href="#features" class="px-8 py-4 rounded-xl bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-gray-200 font-semibold text-lg transition-all">
                        Pelajari Fitur
                    </a>
                </div>

                <div class="pt-8 flex items-center justify-center lg:justify-start gap-8 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                     <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest"></div>
                     <div class="flex gap-4 text-gray-500 dark:text-gray-400 font-bold">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                     </div>
                </div>
            </div>

            <div class="flex-1 w-full max-w-lg relative lg:h-[500px] flex items-center justify-center perspective-1000">
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 to-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
                
                <div class="relative w-full bg-white dark:bg-[#161618] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-2xl p-6 animate-float z-20">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                        <div class="flex flex-col">
                            <div class="h-2 w-24 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                            <div class="h-4 w-40 bg-gray-800 dark:bg-gray-600 rounded"></div>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">12</div>
                            <div class="text-xs text-blue-400 dark:text-blue-300 mt-1">Active Projects</div>
                        </div>
                        <div class="p-4 rounded-xl bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800/50">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">85%</div>
                            <div class="text-xs text-purple-400 dark:text-purple-300 mt-1">Task Completed</div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 border border-transparent hover:border-gray-100 transition-colors cursor-default">
                            <div class="w-5 h-5 rounded-md border-2 border-green-500 flex items-center justify-center">
                                <div class="w-2.5 h-2.5 rounded-sm bg-green-500"></div>
                            </div>
                            <div class="flex-1">
                                <div class="h-3 w-3/4 bg-gray-800 dark:bg-gray-300 rounded mb-1.5"></div>
                                <div class="h-2 w-1/2 bg-gray-300 dark:bg-gray-600 rounded"></div>
                            </div>
                            <div class="h-6 w-16 bg-green-100 dark:bg-green-900/30 rounded text-[10px] text-green-700 dark:text-green-400 flex items-center justify-center font-medium">Selesai</div>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 border border-transparent hover:border-gray-100 transition-colors cursor-default">
                            <div class="w-5 h-5 rounded-md border-2 border-yellow-500"></div>
                            <div class="flex-1">
                                <div class="h-3 w-2/3 bg-gray-800 dark:bg-gray-300 rounded mb-1.5"></div>
                                <div class="h-2 w-1/3 bg-gray-300 dark:bg-gray-600 rounded"></div>
                            </div>
                             <div class="h-6 w-16 bg-yellow-100 dark:bg-yellow-900/30 rounded text-[10px] text-yellow-700 dark:text-yellow-400 flex items-center justify-center font-medium">Proses</div>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 border border-transparent hover:border-gray-100 transition-colors cursor-default">
                            <div class="w-5 h-5 rounded-md border-2 border-gray-300 dark:border-gray-600"></div>
                            <div class="flex-1">
                                <div class="h-3 w-4/5 bg-gray-800 dark:bg-gray-300 rounded mb-1.5"></div>
                                <div class="h-2 w-1/4 bg-gray-300 dark:bg-gray-600 rounded"></div>
                            </div>
                             <div class="h-6 w-16 bg-gray-100 dark:bg-gray-800 rounded text-[10px] text-gray-500 dark:text-gray-400 flex items-center justify-center font-medium">Baru</div>
                        </div>
                    </div>
                </div>

                <div class="absolute -right-4 -bottom-4 lg:bottom-10 lg:-right-10 w-48 bg-white dark:bg-[#1e1e20] p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl animate-float-delayed z-30 hidden sm:block">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-pink-500 to-rose-500"></div>
                        <div>
                            <div class="h-2 w-20 bg-gray-200 dark:bg-gray-600 rounded mb-1"></div>
                            <div class="h-1.5 w-12 bg-gray-100 dark:bg-gray-700 rounded"></div>
                        </div>
                    </div>
                    <div class="h-1.5 w-full bg-gray-100 dark:bg-gray-700 rounded mb-2 overflow-hidden">
                        <div class="h-full w-[70%] bg-green-500 rounded"></div>
                    </div>
                    <div class="text-[10px] text-gray-400 text-right">70% Tasks Done</div>
                </div>
            </div>
        </main>

        <section id="features" class="py-20 bg-white dark:bg-[#0f0f0f] border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="text-center mb-16 max-w-2xl mx-auto">
                    <h2 class="text-3xl font-bold mb-4">Fitur Unggulan</h2>
                    <p class="text-gray-500 dark:text-gray-400">Didesain khusus untuk memenuhi kebutuhan manajemen proyek perangkat lunak, dari perencanaan hingga penyelesaian.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group p-8 rounded-2xl bg-gray-50 dark:bg-[#161618] border border-gray-100 dark:border-gray-800 hover:border-blue-500/30 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 group-hover:text-blue-600 transition-colors">Manajemen Proyek</h3>
                        <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm">
                            Buat proyek baru, tetapkan deskripsi, dan atur tenggat waktu. Dashboard khusus untuk Project Manager dan Admin.
                        </p>
                    </div>

                    <div class="group p-8 rounded-2xl bg-gray-50 dark:bg-[#161618] border border-gray-100 dark:border-gray-800 hover:border-purple-500/30 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-colors">Pelacakan Tugas</h3>
                        <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm">
                            Pantau status tugas (To Do, In Progress, Done). Anggota tim dapat melihat tugas yang diberikan kepada mereka secara spesifik.
                        </p>
                    </div>

                    <div class="group p-8 rounded-2xl bg-gray-50 dark:bg-[#161618] border border-gray-100 dark:border-gray-800 hover:border-green-500/30 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 group-hover:text-green-600 transition-colors">Kolaborasi Tim</h3>
                        <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm">
                            Diskusikan detail tugas melalui fitur komentar, unggah lampiran file, dan jaga komunikasi tim tetap pada jalurnya.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-8 border-t border-gray-200 dark:border-gray-800 text-center relative z-10 bg-white dark:bg-[#0a0a0a]">
            <p class="text-sm text-gray-500 dark:text-gray-500">
                &copy; {{ date('Y') }} Projek SKPL. Dibuat dengan <span class="text-red-500">❤</span> menggunakan Laravel.
            </p>
        </footer>
    </body>
</html>