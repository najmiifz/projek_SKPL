@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Daftar<span class="text-blue-600">Seluruh Tugas</span></h1>
            <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase">Central Task Repository</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[11px] font-black tracking-[0.2em]">
                        <th class="p-6">Informasi Tugas</th>
                        <th class="p-6">Proyek Terkait</th>
                        <th class="p-6">Penanggung Jawab</th>
                        <th class="p-6">Progress / Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-slate-100">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50 transition-all group">
                            <td class="p-6">
                                <div class="flex items-start gap-3">
                                    <div class="w-1.5 h-10 bg-blue-600 rounded-full group-hover:h-12 transition-all"></div>
                                    <div>
                                        <h3 class="font-black text-slate-900 uppercase tracking-tight text-lg">{{ $task->title }}</h3>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">ID: #TSK-{{ $task->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-sm font-black text-slate-700 uppercase tracking-wide">
                                <div class="bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200 inline-block">
                                    {{ $task->project->name ?? 'NO PROJECT' }}
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $task->assignee->avatar ?? 'https://i.pravatar.cc/100?u=' . urlencode($task->assignee->email ?? 'none') }}" 
                                         class="w-10 h-10 rounded-xl object-cover border-2 border-white shadow-md" alt="">
                                    <span class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ $task->assignee->name ?? 'UNASSIGNED' }}</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 text-[10px] font-black rounded-lg uppercase tracking-widest border-2
                                        @if($task->status === 'Done') bg-emerald-50 text-emerald-700 border-emerald-200
                                        @elseif($task->status === 'In Progress') bg-amber-50 text-amber-700 border-amber-200
                                        @elseif($task->status === 'Review') bg-blue-50 text-blue-700 border-blue-200
                                        @else bg-slate-50 text-slate-700 border-slate-200 @endif">
                                        {{ $task->status }}
                                    </span>
                                    
                                    @if(isset($task->progress))
                                    <div class="w-24 bg-slate-100 h-2 rounded-full overflow-hidden border border-slate-200">
                                        <div class="bg-blue-600 h-full transition-all duration-1000" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-900">{{ $task->progress }}%</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-slate-200">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <p class="text-slate-400 font-black uppercase tracking-widest">Belum ada tugas yang dibuat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
