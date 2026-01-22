@extends('layouts.app')

@section('page-title', 'Tugas Saya')

@section('content')
<div class="space-y-6">
    <!-- Statistics -->
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-slate-200">
            <div class="flex items-center">
                <div class="p-3 bg-slate-100 rounded-full border border-slate-200 shadow-inner">
                    <svg class="w-6 h-6 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs text-slate-600 font-black uppercase tracking-widest">To Do</p>
                    <p class="text-3xl font-black text-slate-900">{{ $tasks->where('status', 'To Do')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-yellow-200">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full border border-yellow-300 shadow-inner">
                    <svg class="w-6 h-6 text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs text-yellow-700 font-black uppercase tracking-widest">In Progress</p>
                    <p class="text-3xl font-black text-slate-900">{{ $tasks->where('status', 'In Progress')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-emerald-200">
            <div class="flex items-center">
                <div class="p-3 bg-emerald-100 rounded-full border border-emerald-300 shadow-inner">
                    <svg class="w-6 h-6 text-emerald-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs text-emerald-700 font-black uppercase tracking-widest">Done</p>
                    <p class="text-3xl font-black text-slate-900">{{ $tasks->where('status', 'Done')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-3 gap-6">
        <!-- To Do Column -->
        <div class="bg-slate-200/50 rounded-2xl p-5 border border-slate-300">
            <div class="flex items-center mb-5">
                <span class="w-3.5 h-3.5 bg-slate-600 rounded-full mr-2.5 shadow-sm"></span>
                <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm">To Do</h3>
                <span class="ml-auto bg-slate-700 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $tasks->where('status', 'To Do')->count() }}</span>
            </div>
            <div class="space-y-4">
                @forelse($tasks->where('status', 'To Do') as $task)
                <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-5 rounded-xl border-2 border-slate-200 shadow hover:shadow-xl transition-all hover:-translate-y-1">
                    <h4 class="font-bold text-slate-900 mb-2 leading-tight">{{ $task->title }}</h4>
                    @if($task->project)
                    <p class="text-xs text-slate-700 font-black mb-3 bg-slate-50 p-1.5 rounded border border-slate-200 truncate">{{ $task->project->name }}</p>
                    @endif
                    @if($task->due_date)
                    <div class="flex items-center text-[11px] font-bold {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-700' : 'text-slate-600' }}">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        DEADLINE: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                    </div>
                    @endif
                </a>
                @empty
                <div class="text-center py-12 text-slate-600 font-bold italic bg-white/50 rounded-xl border-2 border-dashed border-slate-300">
                    Kosong
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- In Progress Column -->
        <div class="bg-yellow-100/50 rounded-2xl p-5 border border-yellow-300">
            <div class="flex items-center mb-5">
                <span class="w-3.5 h-3.5 bg-yellow-500 rounded-full mr-2.5 shadow-sm"></span>
                <h3 class="font-black text-yellow-900 uppercase tracking-widest text-sm">In Progress</h3>
                <span class="ml-auto bg-yellow-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $tasks->where('status', 'In Progress')->count() }}</span>
            </div>
            <div class="space-y-4">
                @forelse($tasks->where('status', 'In Progress') as $task)
                <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-5 rounded-xl border-2 border-yellow-200 shadow hover:shadow-xl transition-all hover:-translate-y-1">
                    <h4 class="font-bold text-slate-900 mb-2 leading-tight">{{ $task->title }}</h4>
                    @if($task->project)
                    <p class="text-xs text-yellow-800 font-black mb-3 bg-yellow-50 p-1.5 rounded border border-yellow-200 truncate">{{ $task->project->name }}</p>
                    @endif
                    @if($task->due_date)
                    <div class="flex items-center text-[11px] font-bold {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-700' : 'text-slate-600' }}">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        DEADLINE: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                    </div>
                    @endif
                </a>
                @empty
                <div class="text-center py-12 text-yellow-600 font-bold italic bg-white/50 rounded-xl border-2 border-dashed border-yellow-300">
                    Kosong
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Done Column -->
        <div class="bg-emerald-100/50 rounded-2xl p-5 border border-emerald-300">
            <div class="flex items-center mb-5">
                <span class="w-3.5 h-3.5 bg-emerald-500 rounded-full mr-2.5 shadow-sm"></span>
                <h3 class="font-black text-emerald-900 uppercase tracking-widest text-sm">Selesai</h3>
                <span class="ml-auto bg-emerald-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $tasks->where('status', 'Done')->count() }}</span>
            </div>
            <div class="space-y-4">
                @forelse($tasks->where('status', 'Done') as $task)
                <a href="{{ route('tasks.show', $task) }}" class="block bg-white p-5 rounded-xl border-2 border-emerald-200 shadow hover:shadow-xl transition-all hover:-translate-y-1">
                    <h4 class="font-bold text-slate-900 mb-2 leading-tight line-through opacity-70">{{ $task->title }}</h4>
                    @if($task->project)
                    <p class="text-xs text-emerald-800 font-black mb-3 bg-emerald-50 p-1.5 rounded border border-emerald-200 truncate">{{ $task->project->name }}</p>
                    @endif
                    <div class="flex items-center text-[11px] font-black text-emerald-700 bg-emerald-100 px-2 py-1 rounded w-fit">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        COMPLETE
                    </div>
                </a>
                @empty
                <div class="text-center py-12 text-emerald-600 font-bold italic bg-white/50 rounded-xl border-2 border-dashed border-emerald-300">
                    Belum ada
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
