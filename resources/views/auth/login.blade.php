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
            
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">SIMPRO</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sistem Manajemen Proyek Terintegrasi</p>
        </div>

        <div class="px-8 pb-8">
            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" 
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-[#0a0a0a] text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm" 
                            placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        {{-- Opsi Lupa Password (Bisa diaktifkan nanti) --}}
                        {{-- <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-500">Lupa password?</a> --}}
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" 
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-[#0a0a0a] text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all sm:text-sm" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-500 dark:text-gray-400">
                        Ingat saya
                    </label>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Masuk Dashboard
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-gray-50 dark:bg-[#1a1a1c] px-8 py-4 border-t border-gray-200 dark:border-gray-800 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Belum punya akun? Hubungi <span class="text-blue-600 font-medium">Administrator</span>.
            </p>
        </div>
    </div>
</div>
@endsection