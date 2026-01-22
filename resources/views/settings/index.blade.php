@extends('layouts.app')

@section('page-title', 'Kelola Sistem')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 overflow-hidden">
        <div class="p-8 border-b-2 border-slate-100 bg-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Konfigurasi<span class="text-slate-500">Sistem</span></h1>
                <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase italic">Enterprise Management Settings</p>
            </div>
            <div class="bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-slate-200">
                System Status: <span class="text-emerald-400">Online</span>
            </div>
        </div>
        
        <div class="p-8 space-y-12">
            <!-- General Settings -->
            <div class="group">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Pengaturan Umum</h3>
                </div>
                <form method="POST" action="#" class="space-y-6">
                    @csrf
                    <div class="p-6 bg-slate-50 rounded-3xl border-2 border-slate-100 focus-within:border-blue-500 transition-all shadow-inner">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1">Nama Instansi / Perusahaan</label>
                        <input type="text" class="w-full bg-white border-2 border-slate-200 p-4 rounded-2xl font-black text-slate-800 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm" value="PT. Teknologi Maju">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-3.5 rounded-2xl shadow-lg shadow-blue-100 hover:-translate-y-0.5 transition-all text-sm uppercase tracking-widest">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- User Statistics -->
            <div class="pt-10 border-t-2 border-dashed border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-2 h-8 bg-purple-600 rounded-full"></div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Hirarki Pengguna</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-xl hover:border-purple-200 transition-all hover:-translate-y-1">
                        <p class="text-[10px] font-black text-purple-600 uppercase tracking-[0.3em] mb-2">Administrator</p>
                        <div class="flex items-end gap-2">
                            <span class="text-5xl font-black text-slate-900 leading-none tracking-tighter">{{ \App\Models\User::where('role', 'admin')->count() }}</span>
                            <span class="text-sm font-bold text-slate-400 mb-1">Users</span>
                        </div>
                    </div>
                    <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-xl hover:border-blue-200 transition-all hover:-translate-y-1">
                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] mb-2">Project Manager</p>
                        <div class="flex items-end gap-2">
                            <span class="text-5xl font-black text-slate-900 leading-none tracking-tighter">{{ \App\Models\User::where('role', 'pm')->count() }}</span>
                            <span class="text-sm font-bold text-slate-400 mb-1">Users</span>
                        </div>
                    </div>
                    <div class="p-6 bg-white border-2 border-slate-100 rounded-3xl shadow-xl hover:border-emerald-200 transition-all hover:-translate-y-1">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-2">Team Member</p>
                        <div class="flex items-end gap-2">
                            <span class="text-5xl font-black text-slate-900 leading-none tracking-tighter">{{ \App\Models\User::where('role', 'member')->count() }}</span>
                            <span class="text-sm font-bold text-slate-400 mb-1">Users</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project Statistics -->
            <div class="pt-10 border-t-2 border-dashed border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-2 h-8 bg-amber-600 rounded-full"></div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Metrik Proyek & Tugas</h3>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 bg-slate-900 rounded-3xl shadow-2xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Proyek</p>
                        <p class="text-4xl font-black text-white">{{ \App\Models\Project::count() }}</p>
                    </div>
                    <div class="p-6 bg-white border-2 border-amber-100 rounded-3xl shadow-xl">
                        <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] mb-1">Berjalan</p>
                        <p class="text-4xl font-black text-slate-900">{{ \App\Models\Project::where('status', 'In Progress')->count() }}</p>
                    </div>
                    <div class="p-6 bg-white border-2 border-emerald-100 rounded-3xl shadow-xl">
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-1">Selesai</p>
                        <p class="text-4xl font-black text-slate-900">{{ \App\Models\Project::where('status', 'Done')->count() }}</p>
                    </div>
                    <div class="p-6 bg-blue-600 rounded-3xl shadow-xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-20 transform group-hover:rotate-12 transition-transform">
                            <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0 a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                        </div>
                        <p class="text-[10px] font-black text-blue-100 uppercase tracking-[0.2em] mb-1">Total Tugas</p>
                        <p class="text-4xl font-black text-white">{{ \App\Models\Task::count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endsection
