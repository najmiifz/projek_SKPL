@extends('layouts.app')

@section('page-title', 'Tugas Saya')

@section('content')
<div class="space-y-6">
    <!-- Statistics -->
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-gray-100 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-500">To Do</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $tasks->where('status', 'To Do')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-500">In Progress</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $tasks->where('status', 'In Progress')->count() }}</p>
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
                    <p class="text-sm text-slate-500">Done</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $tasks->where('status', 'Done')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-3 gap-6">
        <!-- To Do Column -->
        <div class="bg-slate-100 rounded-lg p-4">
            <div class="flex items-center mb-4">
                <span class="w-3 h-3 bg-gray-500 rounded-full mr-2"></span>
                <h3 class="font-semibold text-slate-800">To Do</h3>
                <span class="ml-auto bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'To Do')->count() }}</span>
            </div>
            <div class="space-y-3">
                @forelse($tasks->where('status', 'To Do') as $task)
                <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                    <h4 class="font-medium text-slate-800 mb-2">{{ $task->title }}</h4>
                    @if($task->project)
                    <p class="text-xs text-slate-500 mb-2">{{ $task->project->name }}</p>
                    @endif
                    @if($task->due_date)
                    <div class="flex items-center text-xs {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-600' : 'text-slate-500' }}">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                    </div>
                    @endif
                </a>
                @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    Tidak ada tugas
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- In Progress Column -->
        <div class="bg-yellow-50 rounded-lg p-4">
            <div class="flex items-center mb-4">
                <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                <h3 class="font-semibold text-slate-800">In Progress</h3>
                <span class="ml-auto bg-yellow-200 text-yellow-700 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'In Progress')->count() }}</span>
            </div>
            <div class="space-y-3">
                @forelse($tasks->where('status', 'In Progress') as $task)
                <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                    <h4 class="font-medium text-slate-800 mb-2">{{ $task->title }}</h4>
                    @if($task->project)
                    <p class="text-xs text-slate-500 mb-2">{{ $task->project->name }}</p>
                    @endif
                    @if($task->due_date)
                    <div class="flex items-center text-xs {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-600' : 'text-slate-500' }}">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                    </div>
                    @endif
                </a>
                @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    Tidak ada tugas
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Done Column -->
        <div class="bg-green-50 rounded-lg p-4">
            <div class="flex items-center mb-4">
                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                <h3 class="font-semibold text-slate-800">Done</h3>
                <span class="ml-auto bg-green-200 text-green-700 text-xs px-2 py-1 rounded-full">{{ $tasks->where('status', 'Done')->count() }}</span>
            </div>
            <div class="space-y-3">
                @forelse($tasks->where('status', 'Done') as $task)
                <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                    <h4 class="font-medium text-slate-800 mb-2">{{ $task->title }}</h4>
                    @if($task->project)
                    <p class="text-xs text-slate-500 mb-2">{{ $task->project->name }}</p>
                    @endif
                    <div class="flex items-center text-xs text-green-600">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Selesai
                    </div>
                </a>
                @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    Tidak ada tugas
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
