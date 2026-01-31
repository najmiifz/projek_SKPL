@extends('layouts.app')

@section('page-title', 'Detail Tugas')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Navigation --}}
        <div class="py-6 flex items-center justify-between">
            <a href="{{ url()->previous() }}" class="group flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold transition-all italic uppercase text-xs tracking-widest">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Task ID: #{{ $task->id }}</div>
        </div>

        {{-- Flash Message Success --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm animate-fade-in-down flex items-center gap-3">
            <div class="bg-emerald-500 p-1 rounded-full text-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
            <p class="text-emerald-800 text-sm font-bold uppercase tracking-tight">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Main Task Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 overflow-hidden relative">
                    <div class="h-3 bg-blue-600"></div>

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

                            {{-- Progress Circle (Sesuai Database) --}}
                            <div class="flex items-center gap-5 bg-slate-50 p-4 rounded-3xl border border-slate-100">
                                <div class="relative w-16 h-16 flex items-center justify-center">
                                    <svg class="w-full h-full -rotate-90" viewBox="0 0 64 64">
                                        <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="6" fill="transparent" class="text-slate-200" />
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

                        {{-- Description --}}
                        <div class="relative">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-4 flex items-center gap-2 italic">
                                <span class="w-8 h-[2px] bg-blue-600"></span> Deskripsi Tugas
                            </h3>
                            <div class="text-slate-600 leading-relaxed text-lg italic bg-blue-50/30 p-6 rounded-3xl border border-blue-100/50">
                                {{ $task->description ?? 'Tidak ada deskripsi tambahan.' }}
                            </div>
                        </div>

                        {{-- Metadata --}}
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
                    {{-- LAMPIRAN SECTION --}}
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 p-8">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            Lampiran
                        </h3>

                        <div class="space-y-3">
                            @php $files = is_string($task->files) ? json_decode($task->files, true) : ($task->files ?? []); @endphp
                            @forelse($files as $f)
                                @php
                                    $name = is_array($f) ? $f['name'] : $f;
                                    $path = is_array($f) ? $f['path'] : $f;
                                    $link = (\Illuminate\Support\Str::startsWith($path, 'uploads/')) ? asset($path) : asset('storage/'.$path);
                                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                @endphp
                                <a href="{{ $link }}" download="{{ $name }}" class="flex items-center p-3 bg-slate-50 border border-slate-100 rounded-2xl hover:border-blue-200 hover:bg-blue-50 transition-all group overflow-hidden">
                                    @if($isImage)
                                        <div class="w-12 h-12 flex-shrink-0 bg-slate-200 rounded-lg overflow-hidden border border-slate-200 relative">
                                            <img src="{{ $link }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                        </div>
                                    @else
                                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center bg-white rounded-lg shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="ml-3 overflow-hidden flex-1">
                                        <p class="text-xs font-black text-slate-700 truncate uppercase tracking-tighter">{{ $name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-0.5 group-hover:text-blue-500 transition-colors">Unduh file</p>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                                    <p class="text-[10px] font-black text-slate-400 uppercase italic">Belum ada file</p>
                                </div>
                            @endforelse

                            @if(auth()->user()->role === 'member' && $task->assignee_id == auth()->id())
                            <div class="mt-4">
                                <form id="upload-form" action="{{ route('tasks.upload', $task) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label id="upload-label" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-blue-200 rounded-2xl cursor-pointer bg-blue-50/50 hover:bg-blue-50 transition-all group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <div class="p-2 bg-blue-100 rounded-full mb-2 group-hover:bg-blue-200 transition-colors">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                            </div>
                                            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">+ Upload Bukti</p>
                                        </div>
                                        <input type="file" name="file" id="file-input" class="hidden" />
                                    </label>
                                    <div id="progress-container" class="hidden w-full h-24 border-2 border-solid border-blue-100 rounded-2xl bg-white p-4 flex-col justify-center items-center relative overflow-hidden">
                                        <div class="absolute inset-0 bg-blue-50/30 animate-pulse"></div>
                                        <div class="relative w-full z-10">
                                            <div class="flex justify-between items-end mb-2">
                                                <span class="text-[10px] font-black text-blue-600 uppercase italic tracking-widest">Mengupload...</span>
                                                <span id="progress-percent" class="text-xs font-black text-blue-800">0%</span>
                                            </div>
                                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                                <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300 shadow-[0_0_10px_rgba(37,99,235,0.5)]" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="upload-error" class="hidden mt-2 p-3 bg-red-50 text-red-600 text-[10px] font-bold rounded-xl border border-red-100 text-center uppercase">Gagal upload. Coba lagi.</div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- DISKUSI SECTION (Fixed Overflow & Responsiveness) --}}
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 flex flex-col h-[500px]">
                        <div class="p-6 border-b border-slate-50">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Diskusi Tim
                            </h3>
                        </div>

                        <div id="comment-container" class="flex-1 p-6 overflow-y-auto space-y-6 custom-scrollbar bg-slate-50/30">
                            @forelse($task->comments as $c)
                                @php $isMe = $c->user_id === auth()->id(); @endphp
                                <div class="flex {{ $isMe ? 'flex-row-reverse' : 'flex-row' }} items-end gap-3">
                                    <div class="flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($c->user->name) }}&background={{ $isMe ? '0284c7' : 'f1f5f9' }}&color={{ $isMe ? 'fff' : '64748b' }}" class="w-8 h-8 rounded-full shadow-sm" />
                                    </div>
                                    <div class="max-w-[85%] sm:max-w-[75%] space-y-1">
                                        @if(!$isMe)<p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter ml-2">{{ $c->user->name }}</p>@endif
                                        <div class="p-4 rounded-2xl shadow-sm text-sm {{ $isMe ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-slate-600 border border-slate-100 rounded-bl-none' }}">
                                            <p class="leading-relaxed break-words whitespace-pre-wrap" style="word-break: break-word;">{{ $c->body }}</p>
                                        </div>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase {{ $isMe ? 'text-right mr-2' : 'ml-2' }}">{{ $c->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="h-full flex flex-col items-center justify-center text-center p-10 opacity-40 italic">
                                    <p class="text-[10px] font-black text-slate-400 uppercase">Belum ada percakapan</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="p-4 bg-white border-t border-slate-50 rounded-b-[2rem]">
                            <form method="POST" action="{{ route('tasks.comment', $task) }}" class="relative group">
                                @csrf
                                <input type="text" name="body" required autocomplete="off" placeholder="Tulis pesan..." class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-5 pr-14 py-4 text-xs font-bold focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none">
                                <button type="submit" class="absolute right-2 top-2 bottom-2 px-4 bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 active:scale-95 transition-all flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- TASK CONTROL --}}
                <div class="bg-slate-900 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
                    <h3 class="text-xs font-black text-blue-400 uppercase tracking-[0.3em] mb-8 italic text-center">
  Kendali Tugas
</h3>

                    <div class="space-y-4 relative z-10">
                        @php $isAssignee = auth()->user()->role === 'member' && $task->assignee_id == auth()->id(); @endphp

                        @if($isAssignee && $task->status !== 'Done')
                            @if($task->status == 'To Do')
                                <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="In Progress">
                                    <button class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-5 rounded-3xl transition-all shadow-xl shadow-blue-600/20 uppercase italic text-sm tracking-widest">Mulai Kerjakan 🚀</button>
                                </form>
                            @elseif($task->status == 'In Progress')
                                <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Review">
                                    <button class="w-full bg-amber-500 hover:bg-amber-400 text-white font-black py-5 rounded-3xl transition-all shadow-xl shadow-amber-600/20 uppercase italic text-sm tracking-widest">Kirim Review 📤</button>
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
                        @php $isPM = ($task->project && (auth()->user()->role === 'admin' || $task->project->pm_id == auth()->id())); @endphp
                        @if($isPM && $task->status === 'Review')
                        <div class="bg-blue-600 p-8 rounded-[2rem] shadow-xl">
                            <h4 class="text-white font-black uppercase italic text-sm mb-6 flex items-center gap-2">Validasi PM</h4>
                            <form action="{{ route('tasks.validate', [$task->project, $task]) }}" method="POST" class="space-y-4">
                                @csrf
                                <textarea name="feedback" placeholder="Berikan feedback..." class="w-full bg-blue-700/50 border-none rounded-2xl text-white placeholder-blue-300 text-xs font-bold p-4 resize-none" rows="3"></textarea>
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit" name="approval" value="approve" class="bg-white text-blue-600 font-black py-3 rounded-2xl uppercase text-[10px]">Setujui</button>
                                    <button type="submit" name="approval" value="reject" class="bg-red-500 text-white font-black py-3 rounded-2xl uppercase text-[10px]">Tolak</button>
                                </div>
                            </form>
                        </div>
                        @endif

                        @if($task->status == 'Done')
                        <div class="bg-emerald-500 p-8 rounded-[2rem] text-center shadow-xl shadow-emerald-500/20 transform rotate-2">
                            <svg class="w-12 h-12 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <p class="text-white font-black uppercase italic tracking-[0.2em] text-sm leading-none">Tugas Selesai</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Activity Log --}}
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto Scroll Diskusi
        const commentContainer = document.getElementById('comment-container');
        if(commentContainer) {
            commentContainer.scrollTop = commentContainer.scrollHeight;
        }

        // AJAX Upload Handler
        const fileInput = document.getElementById('file-input');
        const uploadForm = document.getElementById('upload-form');
        const uploadLabel = document.getElementById('upload-label');
        const progressContainer = document.getElementById('progress-container');
        const progressBar = document.getElementById('progress-bar');
        const progressPercent = document.getElementById('progress-percent');
        const uploadError = document.getElementById('upload-error');

        if(fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (fileInput.files.length > 0) {
                    uploadLabel.classList.add('hidden');
                    progressContainer.classList.remove('hidden');
                    uploadError.classList.add('hidden');

                    let formData = new FormData(uploadForm);
                    let xhr = new XMLHttpRequest();

                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            const percent = Math.round((e.loaded / e.total) * 100);
                            progressBar.style.width = percent + '%';
                            progressPercent.innerText = percent + '%';
                        }
                    });

                    xhr.addEventListener('load', function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            window.location.reload();
                        } else {
                            progressContainer.classList.add('hidden');
                            uploadLabel.classList.remove('hidden');
                            uploadError.classList.remove('hidden');
                        }
                    });

                    xhr.open('POST', uploadForm.action, true);
                    xhr.send(formData);
                }
            });
        }
    });
</script>
@endsection
