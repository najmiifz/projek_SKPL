@extends('layouts.app')

@section('page-title', 'Kelola Tugas')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 px-4 pb-12">
    
    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-[#0F172A] tracking-tighter uppercase italic leading-none">
                DAFTAR <span class="text-blue-600">SELURUH TUGAS</span>
            </h1>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                <span class="w-8 h-[1px] bg-slate-300"></span> 
                Central Task Repository System
            </p>
        </div>
        <div class="bg-white px-5 py-2.5 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest italic">
                Total: {{ $tasks->count() }} Tugas Terdaftar
            </span>
        </div>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/5 border border-slate-100 overflow-hidden">
        
        {{-- TABLE HEADER --}}
        <div class="bg-[#0F172A] hidden md:grid grid-cols-12 px-10 py-6 text-[10px] font-black text-white uppercase tracking-[0.2em]">
            <div class="col-span-4">Informasi Utama</div>
            <div class="col-span-3 text-center border-l border-slate-800">Proyek</div>
            <div class="col-span-3 text-center border-l border-slate-800">Penanggung Jawab</div>
            <div class="col-span-2 text-center border-l border-slate-800">Status</div>
        </div>

        {{-- TABLE BODY --}}
        <div class="divide-y divide-slate-100">
            @forelse($tasks as $task)
            <div class="grid grid-cols-1 md:grid-cols-12 items-center px-10 py-8 hover:bg-slate-50/80 transition-all group relative">
                
                {{-- Task Info --}}
                <div class="col-span-4 flex items-center gap-6">
                    <div class="w-1.5 h-12 bg-blue-600 rounded-full shadow-[0_0_15px_rgba(37,99,235,0.3)]"></div>
                    <div class="truncate">
                        <h4 class="font-black text-slate-900 text-base uppercase leading-tight tracking-tight group-hover:text-blue-600 transition-colors">
                            {{ $task->title }}
                        </h4>
                        <span class="text-[9px] font-black text-slate-400 bg-slate-100 px-2 py-0.5 rounded italic mt-1.5 inline-block uppercase">#TSK-{{ $task->id }}</span>
                    </div>
                </div>

                {{-- Project --}}
                <div class="col-span-3 flex justify-center">
                    <span class="bg-blue-50 text-blue-700 text-[9px] font-black px-4 py-2 rounded-xl border border-blue-100 uppercase tracking-tighter italic">
                        {{ $task->project->name ?? 'GENERAL' }}
                    </span>
                </div>

                {{-- PENANGGUNG JAWAB (FOTO DARI DATABASE) --}}
                <div class="col-span-3 flex justify-center items-center gap-4">
                    <div class="relative">
                        @php
                            $user = $task->assignee;
                            // Asumsi nama kolom di database adalah 'profile_photo' atau 'avatar'
                            $photoPath = $user->profile_photo ?? $user->avatar ?? null;
                            $picName = $user->name ?? 'Unassigned';
                        @endphp

                        <div class="w-12 h-12 rounded-2xl border-2 border-white shadow-md overflow-hidden bg-slate-100 rotate-2 group-hover:rotate-0 transition-all duration-300">
                            @if($photoPath && file_exists(public_path('storage/' . $photoPath)))
                                {{-- Jika ada foto di storage --}}
                                <img src="{{ asset('storage/' . $photoPath) }}" 
                                     class="w-full h-full object-cover">
                            @elseif($photoPath && (str_starts_with($photoPath, 'http')))
                                {{-- Jika foto berupa URL external --}}
                                <img src="{{ $photoPath }}" 
                                     class="w-full h-full object-cover">
                            @else
                                {{-- Fallback ke UI-Avatars jika database kosong --}}
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($picName) }}&background=0284c7&color=fff&bold=true" 
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                    </div>
                    
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-black text-slate-800 uppercase italic tracking-tight leading-none">
                            {{ $picName }}
                        </span>
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1 italic">
                            Official Team
                        </span>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-span-2 flex flex-col items-center gap-3 px-4">
                    <div class="flex items-center justify-between w-full mb-1">
                        <span class="text-[9px] font-black uppercase italic {{ $task->status == 'Done' ? 'text-emerald-500' : 'text-blue-500' }}">
                            {{ $task->status }}
                        </span>
                        <span class="text-[10px] font-black text-slate-900 italic tracking-tighter">{{ $task->progress ?? 0 }}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden flex items-center">
                        <div class="h-full bg-blue-600 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(37,99,235,0.4)]" 
                             style="width: {{ $task->progress ?? 0 }}%"></div>
                    </div>
                </div>

                {{-- Link Ke Detail --}}
                <a href="{{ route('tasks.show', $task->id) }}" class="absolute inset-0 z-10 opacity-0"></a>
            </div>
            @empty
            <div class="p-20 text-center">
                <p class="font-black text-slate-300 text-[10px] uppercase tracking-[0.5em] italic">Belum Ada Tugas</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection