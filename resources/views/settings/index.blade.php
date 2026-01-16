@extends('layouts.app')

@section('page-title', 'Kelola Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Pengaturan Sistem</h2>
            <p class="text-sm text-slate-500">Konfigurasi umum untuk sistem manajemen proyek</p>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- General Settings -->
            <div>
                <h3 class="text-md font-semibold text-slate-700 mb-4">Pengaturan Umum</h3>
                <form method="POST" action="#" class="space-y-4">
                    @csrf
                    <div class="p-4 bg-slate-50 rounded-lg">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Instansi</label>
                        <input type="text" class="w-full border border-slate-300 p-2 rounded-lg" value="PT. Teknologi Maju">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
            
            <!-- User Statistics -->
            <div class="pt-6 border-t border-slate-200">
                <h3 class="text-md font-semibold text-slate-700 mb-4">Statistik Pengguna</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                        <p class="text-sm text-slate-600">Administrator</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-purple-600">{{ \App\Models\User::where('role', 'pm')->count() }}</p>
                        <p class="text-sm text-slate-600">Project Manager</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-green-600">{{ \App\Models\User::where('role', 'member')->count() }}</p>
                        <p class="text-sm text-slate-600">Anggota Tim</p>
                    </div>
                </div>
            </div>
            
            <!-- Project Statistics -->
            <div class="pt-6 border-t border-slate-200">
                <h3 class="text-md font-semibold text-slate-700 mb-4">Statistik Proyek</h3>
                <div class="grid grid-cols-4 gap-4">
                    <div class="p-4 bg-slate-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-slate-700">{{ \App\Models\Project::count() }}</p>
                        <p class="text-sm text-slate-600">Total Proyek</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Project::where('status', 'In Progress')->count() }}</p>
                        <p class="text-sm text-slate-600">Sedang Berjalan</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-green-600">{{ \App\Models\Project::where('status', 'Done')->count() }}</p>
                        <p class="text-sm text-slate-600">Selesai</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-gray-600">{{ \App\Models\Task::count() }}</p>
                        <p class="text-sm text-slate-600">Total Tugas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
