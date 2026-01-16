@extends('layouts.app')

@section('page-title', 'Laporan Proyek')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-500">Total Proyek</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $statistics['total_projects'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-500">Proyek Selesai</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $statistics['completed_projects'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-500">Total Tugas</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $statistics['total_tasks'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-500">Tugas Selesai</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $statistics['completed_tasks'] }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Project List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Daftar Proyek Saya</h2>
            <a href="{{ route('reports.download') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download Laporan
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Nama Proyek</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($projects as $project)
                    @php
                        $totalTasks = $project->tasks->count();
                        $doneTasks = $project->tasks->where('status', 'Done')->count();
                        $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800">{{ $project->name }}</div>
                            <div class="text-sm text-slate-500">{{ Str::limit($project->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($project->status == 'Done') bg-green-100 text-green-800
                                @elseif($project->status == 'In Progress') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $project->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $doneTasks }}/{{ $totalTasks }} selesai
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-24 bg-slate-200 rounded-full h-2 mr-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-sm text-slate-600">{{ $progress }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada proyek
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
