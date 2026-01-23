@extends('layouts.app')

@section('page-title', 'Kelola Tugas')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="text-center md:text-left mb-10">
        <h1 class="text-3xl font-black text-[#0F172A] tracking-tighter uppercase italic">
            DAFTAR <span class="text-blue-600">SELURUH TUGAS</span>
        </h1>
        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.4em] mt-1">Central Task Repository</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-simpro border border-slate-100 overflow-hidden">
        <div class="bg-[#0F172A] grid grid-cols-12 px-8 py-5 text-[10px] font-black text-white uppercase tracking-[0.15em]">
            <div class="col-span-4">Informasi Tugas</div>
            <div class="col-span-3 text-center">Proyek Terkait</div>
            <div class="col-span-3 text-center border-l border-slate-800">Penanggung Jawab</div>
            <div class="col-span-2 text-center border-l border-slate-800">Progress / Status</div>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($tasks as $task)
            <div class="grid grid-cols-12 items-center px-8 py-6 hover:bg-slate-50 transition-all group">
                <div class="col-span-4 flex items-center gap-5">
                    <div class="w-1.5 h-14 bg-blue-600 rounded-full shadow-[0_0_15px_rgba(37,99,235,0.4)]"></div>
                    <div class="truncate">
                        <h4 class="font-black text-slate-900 text-sm uppercase leading-none tracking-tight group-hover:text-blue-600 transition-colors">
                            {{ $task->title }}
                        </h4>
                        <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase">ID: #TSK-{{ $task->id }}</p>
                    </div>
                </div>

                <div class="col-span-3 flex justify-center">
                    <span class="bg-slate-100 text-slate-500 text-[9px] font-black px-4 py-2 rounded-xl border border-slate-200 uppercase tracking-tighter">
                        {{ $task->project->name ?? 'GENERAL' }}
                    </span>
                </div>

                <div class="col-span-3 flex justify-center items-center gap-3">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($task->user->name ?? 'U') }}&background=0D8ABC&color=fff" 
                             class="w-9 h-9 rounded-full border-2 border-white shadow-md object-cover">
                    </div>
                    <span class="text-[11px] font-black text-slate-700 uppercase italic tracking-tight">
                        {{ $task->user->name ?? 'Unassigned' }}
                    </span>
                </div>

                <div class="col-span-2 flex flex-col items-center gap-3 px-4">
                    <div class="flex items-center justify-between w-full">
                        <span class="px-3 py-1 rounded-lg border text-[8px] font-black uppercase {{ $task->status == 'Done' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-blue-50 text-blue-600 border-blue-200' }}">
                            {{ $task->status }}
                        </span>
                        <span class="text-[10px] font-black text-slate-900 italic">{{ $task->progress ?? 0 }}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden flex items-center">
                        <div class="h-full bg-blue-600 rounded-full shadow-[0_0_8px_rgba(37,99,235,0.3)]" style="width: {{ $task->progress ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-20 text-center opacity-40">
                <p class="font-black text-xs uppercase tracking-widest italic">Belum Ada Tugas Yang Terdaftar</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection