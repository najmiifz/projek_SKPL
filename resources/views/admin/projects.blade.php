@extends('layouts.app')

@section('page-title', 'Semua Proyek')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Semua Proyek</h1>
        <a href="{{ route('admin.dashboard') }}" 
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Kembali ke Dashboard
        </a>
    </div>

    @if($projects->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($projects as $project)
                <li class="hover:bg-gray-50 transition-colors">
                    <a href="{{ route('admin.projects.show', $project) }}" class="block px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <div>
                                    <p class="text-lg font-medium text-indigo-600 hover:text-indigo-800">
                                        {{ $project->name }}
                                    </p>
                                    <p class="text-sm text-slate-800 mt-1 font-bold">
                                        <span class="font-black text-slate-900">PM:</span> {{ $project->pmUser->name ?? 'Unassigned' }}
                                    </p>
                                    <p class="text-sm text-slate-700 mt-1 leading-relaxed">
                                        {{ $project->description }}
                                    </p>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0 flex items-center space-x-4">
                                <p class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full uppercase tracking-wider
                                    @if($project->status == 'Done') bg-green-200 text-green-900 border border-green-300
                                    @elseif($project->status == 'In Progress') bg-yellow-200 text-yellow-900 border border-yellow-300
                                    @else bg-slate-200 text-slate-900 border border-slate-300 @endif">
                                    {{ $project->status }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-slate-700 space-x-4 font-bold">
                            <span class="flex items-center gap-1"><span class="bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded">📋 Tasks: {{ $project->tasks->count() }}</span></span>
                            <span class="flex items-center gap-1"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded">✓ Selesai: {{ $project->tasks->where('status', 'Done')->count() }}</span></span>
                            <span class="text-slate-500 font-medium">📅 Created: {{ $project->created_at->format('d/m/Y') }}</span>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-xl border-2 border-dashed border-slate-300 p-12 text-center mt-10">
            <svg class="w-20 h-20 mx-auto text-slate-400 mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <p class="text-slate-900 text-2xl font-black mb-2">Belum ada proyek yang dibuat</p>
            <p class="text-slate-600 font-bold">Pastikan Anda telah menambahkan proyek melalui Dashboard atau seeder.</p>
        </div>
    @endif
</div>
@endsection