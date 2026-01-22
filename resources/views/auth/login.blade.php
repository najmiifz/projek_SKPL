@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center relative w-full px-4 py-12">
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] right-[-5%] w-[30%] h-[30%] bg-blue-400/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[30%] h-[30%] bg-purple-400/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="w-full max-w-[400px] bg-white dark:bg-[#161618] rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 overflow-hidden relative">
        
        <div class="px-8 pt-8 pb-6 text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('img/logo simpro.jpeg') }}" alt="Logo" class="h-14 w-auto object-contain rounded-lg shadow-md border border-gray-100 dark:border-gray-800">
            </div>
            
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight leading-none">SIMPRO</h2>
            <p class="text-sm text-slate-700 dark:text-slate-300 mt-2 font-medium">Sistem Manajemen Proyek Terintegrasi</p>
        </div>

        <div class="px-8 pb-8">
            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 mb-1.5 uppercase tracking-wide">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" 
                            class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 dark:border-slate-800 rounded-xl bg-white dark:bg-[#0a0a0a] text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all sm:text-sm font-medium" 
                            placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-600 dark:text-red-400 text-xs mt-1.5 font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wide">Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" 
                            class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 dark:border-slate-800 rounded-xl bg-white dark:bg-[#0a0a0a] text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all sm:text-sm font-medium" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded cursor-pointer">
                    <label for="remember-me" class="ml-2 block text-sm text-slate-700 dark:text-slate-300 font-bold cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-black rounded-xl text-white bg-slate-900 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all shadow-xl hover:-translate-y-1 uppercase tracking-widest">
                        Masuk Dashboard
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-slate-50 dark:bg-[#1a1a1c] px-8 py-5 border-t border-slate-200 dark:border-slate-800 text-center">
            <p class="text-xs text-slate-600 dark:text-slate-400 font-bold">
                Belum punya akun? Hubungi <span class="text-blue-600 font-black">Administrator</span>.
            </p>
        </div>
    </div>
</div>
@endsection