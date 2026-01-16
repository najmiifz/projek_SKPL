@extends('layouts.app')

@section('page-title', 'Detail Proyek')

@section('content')
<div class="space-y-6">
    <!-- Project Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $project->name }}</h1>
                <p class="text-slate-600 mt-1">{{ $project->description }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                @if($project->status == 'Done') bg-green-100 text-green-800
                @elseif($project->status == 'In Progress') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ $project->status }}
            </span>
        </div>
        
        <div class="grid grid-cols-3 gap-4 mt-4 text-sm">
            <div class="flex items-center text-slate-600">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                Mulai: {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}
            </div>
            <div class="flex items-center text-slate-600">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                Selesai: {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : '-' }}
            </div>
            <div class="flex items-center text-slate-600">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                PM: {{ $project->pmUser->name ?? '-' }}
            </div>
        </div>
    </div>
    
    <!-- My Tasks in this Project -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Tugas Saya di Proyek Ini</h2>
        </div>
        
        <div class="divide-y divide-slate-200">
            @forelse($tasks as $task)
            <a href="{{ route('tasks.show', $task) }}" class="block p-4 hover:bg-slate-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-slate-800">{{ $task->title }}</h3>
                        <p class="text-sm text-slate-500">{{ Str::limit($task->description, 100) }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($task->status == 'Done') bg-green-100 text-green-800
                            @elseif($task->status == 'In Progress') bg-yellow-100 text-yellow-800
                            @elseif($task->status == 'Review') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $task->status }}
                        </span>
                        @if($task->due_date)
                        <span class="text-xs {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-600' : 'text-slate-500' }}">
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                        </span>
                        @endif
                        <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-8 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
                <p>Belum ada tugas untuk kamu di proyek ini</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
