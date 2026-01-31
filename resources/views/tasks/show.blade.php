@extends('layouts.app')

@section('page-title', 'Detail Tugas')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="py-6 flex items-center justify-between">
            <a href="{{ url()->previous() }}" class="group flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold transition-all italic uppercase text-xs tracking-widest">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Task ID: #{{ $task->id }}</div>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm animate-fade-in-down flex items-center gap-3">
            <div class="bg-emerald-500 p-1 rounded-full text-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
            <p class="text-emerald-800 text-sm font-bold uppercase tracking-tight">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 overflow-hidden relative">
                    <div class="h-3 bg-blue-600"></div> {{-- Top Accent Bar --}}

                    <div class="p-8 md:p-12">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                            <div>
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-4 py-1.5 rounded-full border border-blue-100 uppercase tracking-[0.2em] mb-4 inline-block italic">
                                    {{ $task->project->name ?? 'General Project' }}
                                </span>
                                <h1 class="text-4xl font-black text-slate-900 tracking-tighter leading-tight uppercase italic">
                                    {{ $task->title }}
                                </h1>
                            </div>

                            {{-- Progress Circle/Status --}}
<div class="flex items-center gap-5 bg-slate-50 p-4 rounded-3xl border border-slate-100">
    <div class="relative w-16 h-16 flex items-center justify-center">
        {{--
            FIX:
            1. Menambahkan viewBox="0 0 64 64" agar koordinat sinkron.
            2. Menambahkan stroke-linecap="round" agar ujung garisnya membulat (rapi).
        --}}
        <svg class="w-full h-full -rotate-90" viewBox="0 0 64 64">
            {{-- Background Circle (Abu-abu) --}}
            <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-200" />

            {{-- Progress Circle (Biru) --}}
            <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent"
                stroke-dasharray="175.9"
                stroke-dashoffset="{{ 175.9 - (175.9 * ($task->progress ?? 0) / 100) }}"
                stroke-linecap="round"
                class="text-blue-600 transition-all duration-1000" />
        </svg>
        <span class="absolute text-xs font-black text-slate-800 tracking-tighter">{{ $task->progress ?? 0 }}%</span>
    </div>
    <div class="text-right">
        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Status</p>
        <p class="font-black text-slate-900 uppercase italic leading-none">{{ $task->status }}</p>
    </div>
</div>
                        </div>

                        <div class="relative">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-4 flex items-center gap-2 italic">
                                <span class="w-8 h-[2px] bg-blue-600"></span> Deskripsi Tugas
                            </h3>
                            <div class="text-slate-600 leading-relaxed text-lg italic bg-blue-50/30 p-6 rounded-3xl border border-blue-100/50">
                                {{ $task->description ?? 'Tidak ada deskripsi tambahan.' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-10 pt-10 border-t border-slate-100">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dibuat Oleh</p>
                                <p class="font-bold text-slate-800 italic uppercase">System Admin</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Assignee</p>
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($task->assignee->name ?? 'U') }}&background=0284c7&color=fff" class="w-5 h-5 rounded-full" />
                                    <p class="font-bold text-slate-800 italic uppercase">{{ $task->assignee->name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Deadline</p>
                                <p class="font-bold text-slate-800 italic uppercase text-red-500">{{ $task->due_date ? date('d M, Y', strtotime($task->due_date)) : 'No Deadline' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-8">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            Lampiran
                        </h3>

                        <div class="space-y-3">
                            @php
                                $files = is_string($task->files) ? json_decode($task->files, true) : ($task->files ?? []);
                            @endphp

                            @forelse($files as $f)
                                @php
                                    $name = is_array($f) ? $f['name'] : $f;
                                    $path = is_array($f) ? $f['path'] : $f;
                                    $link = (\Illuminate\Support\Str::startsWith($path, 'uploads/')) ? asset($path) : asset('storage/'.$path);
                                @endphp
                                <a href="{{ $link }}" target="_blank" class="flex items-center p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-blue-200 hover:bg-blue-50 transition-all group">
                                    <div class="p-2 bg-white rounded-lg shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="ml-3 overflow-hidden">
                                        <p class="text-xs font-black text-slate-700 truncate uppercase tracking-tighter">{{ $name }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                                    <p class="text-[10px] font-black text-slate-400 uppercase italic">Belum ada file</p>
                                </div>
                            @endforelse

                            @if(auth()->user()->role === 'member' && $task->assignee_id == auth()->id())
                            <form action="{{ route('tasks.upload', $task) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                                @csrf
                                <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-blue-200 rounded-2xl cursor-pointer bg-blue-50/50 hover:bg-blue-50 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">+ Upload Bukti</p>
                                    </div>
                                    <input type="file" name="file" class="hidden" onchange="this.form.submit()" />
                                </label>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-8 flex flex-col">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Diskusi
                        </h3>

                        <div class="flex-1 space-y-4 max-h-[300px] overflow-y-auto mb-6 pr-2 custom-scrollbar">
                            @forelse($task->comments as $c)
                            <div class="flex gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($c->user->name) }}&background=f1f5f9&color=64748b" class="w-8 h-8 rounded-full" />
                                <div class="flex-1 bg-slate-50 p-4 rounded-2xl rounded-tl-none border border-slate-100">
                                    <div class="flex justify-between mb-1">
                                        <p class="text-[10px] font-black text-slate-900 uppercase tracking-tighter">{{ $c->user->name }}</p>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase">{{ $c->created_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ $c->body }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-[10px] font-black text-slate-400 uppercase py-10 italic">Belum ada percakapan</p>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('tasks.comment', $task) }}" class="relative mt-auto">
                            @csrf
                            <input type="text" name="body" placeholder="Tulis pesan..." class="w-full bg-slate-100 border-none rounded-2xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-blue-500 transition-all outline-none">
                            <button class="absolute right-2 top-2 p-1.5 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                {{-- Task Actions --}}
                <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl shadow-blue-900/20 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>

                    <h3 class="text-xs font-black text-blue-400 uppercase tracking-[0.3em] mb-8 italic">Kendali Tugas</h3>

                    <div class="space-y-4 relative z-10">
                        @php $isAssignee = auth()->user()->role === 'member' && $task->assignee_id == auth()->id(); @endphp

                        @if($isAssignee && $task->status !== 'Done')
                            @if($task->status == 'To Do')
                            <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="In Progress">
                                <button class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-3xl transition-all transform hover:scale-[1.02] shadow-xl shadow-blue-600/20 uppercase tracking-widest italic text-sm">
                                    Mulai Kerjakan 🚀
                                </button>
                            </form>
                            @elseif($task->status == 'In Progress')
                            <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Review">
                                <button class="w-full bg-amber-500 hover:bg-amber-400 text-white font-black py-5 rounded-3xl transition-all transform hover:scale-[1.02] shadow-xl shadow-amber-600/20 uppercase tracking-widest italic text-sm">
                                    Kirim Review 📤
                                </button>
                            </form>
                            @elseif($task->status == 'Review')
                            <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-3xl text-center">
                                <div class="w-12 h-12 bg-amber-500/20 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Menunggu Validasi PM</p>
                            </div>
                            @endif
                        @endif

                        {{-- PM Validation --}}
                        @php
                            $isPM = ($task->project && (auth()->user()->role === 'admin' || $task->project->pm_id == auth()->id()));
                        @endphp

                        @if($isPM && $task->status === 'Review')
                        <div class="bg-blue-600 p-8 rounded-[2rem] shadow-xl">
                            <h4 class="text-white font-black uppercase italic tracking-widest text-sm mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Validasi PM
                            </h4>
                            <form action="{{ route('tasks.validate', [$task->project, $task]) }}" method="POST" class="space-y-4">
                                @csrf
                                <textarea name="feedback" placeholder="Berikan feedback..." class="w-full bg-blue-700/50 border-blue-400/50 rounded-2xl text-white placeholder-blue-300 text-xs font-bold focus:ring-white transition-all resize-none p-4" rows="3"></textarea>

                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit" name="approval" value="approve" class="bg-white text-blue-600 font-black py-3 rounded-2xl hover:bg-slate-100 transition-all uppercase text-[10px] tracking-tighter">Setujui</button>
                                    <button type="submit" name="approval" value="reject" class="bg-red-500 text-white font-black py-3 rounded-2xl hover:bg-red-600 transition-all uppercase text-[10px] tracking-tighter">Tolak</button>
                                </div>
                            </form>
                        </div>
                        @endif

                        @if($task->status == 'Done')
                        <div class="bg-emerald-500 p-8 rounded-[2rem] text-center shadow-xl shadow-emerald-500/20 transform rotate-2">
                            <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <p class="text-white font-black uppercase italic tracking-[0.2em] text-sm leading-none">Tugas Selesai</p>
                            <p class="text-emerald-100 text-[10px] font-bold mt-1 uppercase">Valid & Verified</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Meta --}}
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 italic">Log Aktivitas</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                            <p class="text-[10px] font-black text-slate-600 uppercase">Input: {{ $task->created_at->format('d/m/y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full"></div>
                            <p class="text-[10px] font-black text-slate-600 uppercase">Update: {{ $task->updated_at->format('d/m/y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fade-in-down 0.5s ease-out;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection
