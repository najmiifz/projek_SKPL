@extends('layouts.app')

@section('page-title', 'Detail Tugas')

@section('content')
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-100 to-slate-50 pb-8">
    <div class="max-w-6xl mx-auto px-4">
      
      <!-- Success Message -->
      @if(session('success'))
      <div class="mt-6 mb-6 p-4 bg-gradient-to-r from-slate-50 to-slate-50 border-l-4 border-slate-500 text-slate-700 rounded-lg shadow-md flex items-start gap-3 animate-pulse">
        <svg class="w-6 h-6 mt-0.5 flex-shrink-0 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <div class="flex-1">
          <p class="font-bold text-lg">✓ Berhasil!</p>
          <p class="text-sm mt-1">{{ session('success') }}</p>
        </div>
      </div>
      @endif

      <!-- Error Message -->
      @if(session('error'))
      <div class="mt-6 mb-6 p-4 bg-gradient-to-r from-slate-50 to-slate-50 border-l-4 border-slate-500 text-slate-700 rounded-lg shadow-md flex items-start gap-3">
        <svg class="w-6 h-6 mt-0.5 flex-shrink-0 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        <div class="flex-1">
          <p class="font-bold text-lg">✗ Error</p>
          <p class="text-sm mt-1">{{ session('error') }}</p>
        </div>
      </div>
      @endif

      <!-- Back button -->
      <div class="mt-6 mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-700 font-semibold transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          ← Kembali
        </a>
      </div>

      <!-- Main Grid Layout -->
      <div class="grid grid-cols-3 gap-6">
        <!-- Left Column (2/3) -->
        <div class="col-span-2 space-y-6">
          
          <!-- Task Header Card -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
            <!-- Header Background -->
            <div class="h-32 bg-gradient-to-r from-slate-600 via-slate-700 to-slate-600 relative overflow-hidden">
              <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=%2760%27 height=%2760%27 viewBox=%270 0 60 60%27 xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cg fill=%27none%27 fill-rule=%27evenodd%27%3E%3Cg fill=%27%23ffffff%27 fill-opacity=%270.5%27%3E%3Cpath d=%27M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%27/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
            </div>

            <!-- Content -->
            <div class="px-6 pb-6 -mt-16 relative">
              <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                  <h1 class="text-3xl font-bold text-slate-800 mb-3">{{ $task->title }}</h1>
                  <div class="space-y-2 text-sm">
                    <p class="flex items-center gap-2 text-slate-600">
                      <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM4 9a1 1 0 100 2h8a1 1 0 100-2H4z"/></svg>
                      <span class="font-medium text-slate-700">Proyek:</span> <span class="text-slate-600 font-semibold">{{ $task->project->name ?? 'N/A' }}</span>
                    </p>
                    @if($task->assignee)
                    <p class="flex items-center gap-2 text-slate-600">
                      <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                      <span class="font-medium text-slate-700">Tim Member:</span> <span class="text-slate-600 font-semibold">{{ $task->assignee->name }}</span>
                    </p>
                    @endif
                  </div>
                </div>
                <div class="text-center bg-gradient-to-br from-slate-100 to-slate-50 rounded-xl p-4 shadow-sm border border-slate-300">
                  <span class="block px-4 py-2 rounded-full text-sm font-bold
                    @if($task->status == 'Done') bg-gradient-to-r from-slate-100 to-slate-100 text-slate-700
                    @elseif($task->status == 'In Progress') bg-gradient-to-r from-slate-100 to-slate-100 text-slate-700
                    @elseif($task->status == 'Review') bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700
                    @else bg-gradient-to-r from-gray-100 to-slate-100 text-slate-700 @endif">
                    {{ $task->status }}
                  </span>
                  @if($task->progress)
                  <div class="mt-4">
                    <p class="text-xs text-slate-700 font-bold mb-2 uppercase tracking-wider">Progress</p>
                    <div class="w-28 h-3 bg-slate-200 rounded-full overflow-hidden border border-slate-300 shadow-inner">
                      <div class="h-full bg-slate-600 transition-all duration-500 rounded-full" style="width: {{ $task->progress }}%"></div>
                    </div>
                    <p class="text-sm text-slate-900 mt-2 font-black">{{ $task->progress }}%</p>
                  </div>
                  @endif
                </div>
              </div>

              @if($task->description)
              <div class="mt-6 pt-6 border-t border-slate-200">
                <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2 uppercase tracking-wide">
                  <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V9a1 1 0 10-2 0v8a1 1 0 01-1 1H4a1 1 0 01-1-1V5z" clip-rule="evenodd"/></svg>
                  Deskripsi Tugas
                </h3>
                <p class="text-slate-700 leading-relaxed bg-gradient-to-br from-slate-50 to-indigo-50 p-4 rounded-lg border border-slate-200">{{ $task->description }}</p>
              </div>
              @endif
            </div>
          </div>

          <!-- Lampiran File Section -->
          @php $canUpload = auth()->user()->role === 'member' && $task->assignee_id == auth()->id(); @endphp
          
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-50">
              <h3 class="font-bold text-lg text-slate-800 flex items-center gap-3 uppercase tracking-wide">
                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg>
                📎 Lampiran & Bukti Pekerjaan
              </h3>
            </div>
            
            <div class="p-6">
              @if($canUpload)
              <form action="{{ route('tasks.upload', $task) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                @csrf
                <div class="border-2 border-dashed border-slate-300 p-8 text-center rounded-xl hover:border-slate-500 hover:bg-slate-50 transition bg-gradient-to-br from-slate-50 to-slate-50 group">
                  <svg class="w-16 h-16 mx-auto text-slate-400 mb-3 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                  <input type="file" name="file" class="mb-3 cursor-pointer">
                  <p class="text-sm text-slate-700 font-bold">Drag & drop atau klik untuk memilih file</p>
                  <p class="text-xs text-slate-500 mt-1">Ukuran maksimal 5MB</p>
                </div>
                <div class="flex justify-end mt-4">
                  <button type="submit" class="bg-gradient-to-r from-slate-600 to-slate-600 hover:from-slate-700 hover:to-slate-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 shadow-lg transition transform hover:scale-105 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Upload File
                  </button>
                </div>
              </form>
              @else
              <div class="p-4 bg-white border-2 border-slate-300 rounded-lg shadow-sm">
                <p class="text-sm text-slate-800 font-bold">
                  @if(auth()->user()->role === 'admin')
                    👤 <strong>Admin View:</strong> Fitur upload hanya untuk anggota tim yang ditugaskan.
                  @elseif(auth()->user()->role === 'pm')
                    👨‍💼 <strong>PM View:</strong> Fitur upload hanya untuk anggota tim yang ditugaskan.
                  @else
                    ❌ <strong>Anda tidak ditugaskan untuk tugas ini.</strong>
                  @endif
                </p>
              </div>
              @endif

              @php
                $files = [];
                if ($task->files) {
                    if (is_string($task->files)) {
                        $decoded = json_decode($task->files, true);
                        $files = is_array($decoded) ? $decoded : [];
                    } elseif (is_array($task->files) || $task->files instanceof \Illuminate\Support\Collection) {
                        $files = $task->files;
                    }
                }
              @endphp

              @if(!empty($files))
                <div class="mt-6 pt-6 border-t border-slate-200">
                  <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2 uppercase tracking-wide">
                    <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"/></svg>
                    File Terupload ({{ count($files) }})
                  </h4>
                  <ul class="space-y-2">
                    @foreach($files as $f)
                      @php $name = is_array($f) && isset($f['name']) ? $f['name'] : (is_string($f) ? $f : 'file'); @endphp
                      @php $path = is_array($f) && isset($f['path']) ? $f['path'] : (is_string($f) ? $f : null); @endphp
                      @if($path)
                        @php
                          $link = (\Illuminate\Support\Str::startsWith($path, 'uploads/')) ? asset($path) : asset('storage/'.$path);
                        @endphp
                        <li class="flex items-center p-3 bg-gradient-to-r from-slate-50 to-slate-50 rounded-lg border-2 border-slate-200 hover:shadow-md transition">
                          <svg class="w-5 h-5 text-slate-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                          <a href="{{ $link }}" target="_blank" class="text-slate-700 hover:text-slate-800 font-bold flex-1">{{ $name }}</a>
                          <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m-4-4l4 4m0 0l4-4m-4 4v12"/></svg>
                        </li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              @else
                <div class="text-center py-10 text-slate-600 bg-slate-50 rounded-xl border-2 border-dashed border-slate-300">
                  <svg class="w-12 h-12 mx-auto mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" clip-rule="evenodd"/></svg>
                  <p class="font-bold text-lg">Belum ada file yang diupload</p>
                  <p class="text-sm mt-1">Gunakan form di atas untuk mengunggah bukti pekerjaan.</p>
                </div>
              @endif
            </div>
          </div>

          <!-- Diskusi Section -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-50">
              <h3 class="font-bold text-lg text-slate-800 flex items-center gap-3 uppercase tracking-wide">
                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"/></svg>
                💬 Diskusi & Komentar
              </h3>
            </div>

            <div class="p-6">
              <div class="space-y-4 max-h-96 overflow-y-auto mb-6 bg-slate-50 p-4 rounded-lg border-2 border-slate-200">
                @if($task->comments->isEmpty())
                  <div class="text-center text-slate-600 py-10">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-bold text-lg">Belum ada komentar</p>
                    <p class="text-sm mt-1">Jadilah yang pertama memberikan tanggapan.</p>
                  </div>
                @endif
                @foreach($task->comments as $c)
                  <div class="flex gap-3 pb-4 border-b border-slate-300 last:border-b-0">
                    <div class="w-10 h-10 rounded-full bg-slate-600 flex items-center justify-center text-white font-bold flex-shrink-0 text-sm shadow-sm">
                      {{ strtoupper(substr($c->user->name,0,1)) }}
                    </div>
                    <div class="flex-1">
                      <div class="flex items-center justify-between">
                        <div class="font-black text-slate-900 text-sm uppercase tracking-tight">{{ $c->user->name }}</div>
                        <div class="text-[10px] font-bold text-slate-500 bg-slate-200 px-2 py-0.5 rounded uppercase">{{ $c->created_at->diffForHumans() }}</div>
                      </div>
                      <div class="text-sm text-slate-800 mt-1.5 bg-white p-3 rounded-lg border-2 border-slate-200 shadow-sm leading-relaxed">{{ $c->body }}</div>
                    </div>
                  </div>
                @endforeach
              </div>

              <form method="POST" action="{{ route('tasks.comment', $task) }}" class="flex gap-2">
                @csrf
                <input type="text" name="body" class="flex-1 border-2 border-slate-300 rounded-lg px-4 py-3 focus:outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition" placeholder="Tulis komentar...">
                <button class="bg-gradient-to-r from-slate-600 to-slate-600 text-white px-6 py-3 rounded-lg hover:from-slate-700 hover:to-slate-700 transition transform hover:scale-105 font-bold">Kirim</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Right Column (1/3) -->
        <div class="col-span-1">
          <!-- Status Update Section -->
          @if($canUpload && $task->status !== 'Done')
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200 sticky top-20">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-50">
              <h3 class="font-bold text-slate-800 flex items-center gap-2 uppercase tracking-wide">
                <svg class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                Perubahan Status
              </h3>
            </div>
            
            <div class="p-6 space-y-4">
              @if($task->status == 'To Do')
              <form action="{{ route('tasks.update-status', $task) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="In Progress">
                <button type="submit" class="w-full bg-gradient-to-r from-slate-600 to-slate-600 hover:from-slate-700 hover:to-slate-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 shadow-lg transition transform hover:scale-105">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                  🚀 Mulai Mengerjakan
                </button>
              </form>
              @elseif($task->status == 'In Progress')
              <form action="{{ route('tasks.update-status', $task) }}" method="POST" id="submitForm" onsubmit="handleSubmit(event)">
                @csrf
                <input type="hidden" name="status" value="Review">
                <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-slate-600 to-slate-600 hover:from-slate-700 hover:to-slate-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 shadow-lg transition transform hover:scale-105">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                  📤 Kirim untuk Validasi
                </button>
              </form>
              @elseif($task->status == 'Review')
              <div class="p-5 bg-gradient-to-br from-slate-50 to-indigo-50 border-2 border-slate-300 rounded-lg text-center">
                <p class="text-slate-700 font-bold text-2xl">⏳</p>
                <p class="text-slate-800 font-bold mt-2 text-sm">Menunggu Validasi</p>
                <p class="text-slate-600 text-xs mt-2">PM akan segera me-review tugas Anda</p>
              </div>
              @endif
            </div>
          </div>
          @endif

          <!-- PM Validation Section -->
          @php
            $isValidationAllowed = ($task->status === 'Review') && 
                                   ($task->project && (
                                     auth()->user()->role === 'admin' || 
                                     $task->project->pm_id == auth()->id()
                                   ));
          @endphp
          
          @if($isValidationAllowed)
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-slate-300 sticky top-20 mt-6">
            <div class="px-6 py-4 border-b border-slate-300 bg-gradient-to-r from-slate-50 to-slate-50">
              <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                🔍 Validasi Tugas
              </h3>
            </div>

            <div class="p-6 space-y-4">
              <p class="text-sm text-slate-800 bg-slate-50 p-3 rounded-lg border border-slate-200 font-semibold">
                Tugas ini sudah di-submit untuk review. Silakan validasi hasil kerja anggota tim.
              </p>

              <form action="{{ route('tasks.validate', [$task->project, $task]) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">💬 Feedback (opsional)</label>
                  <textarea name="feedback" rows="3" 
                            class="w-full px-4 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition resize-none font-medium"
                            placeholder="Berikan feedback atau alasan penolakan..."></textarea>
                </div>
                
                <div class="space-y-3">
                  <button type="submit" name="approval" value="approve" 
                          class="w-full bg-gradient-to-r from-slate-600 to-slate-600 hover:from-slate-700 hover:to-slate-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 shadow-lg transition transform hover:scale-105">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    ✓ Setujui & Selesaikan
                  </button>
                  <button type="submit" name="approval" value="reject" 
                          class="w-full bg-gradient-to-r from-slate-600 to-slate-600 hover:from-slate-700 hover:to-slate-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center gap-2 shadow-lg transition transform hover:scale-105"
                          onclick="return confirm('Yakin ingin menolak tugas ini? Anggota harus mengerjakan ulang.');"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    ✗ Tolak
                  </button>
                </div>
              </form>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <script>
    function handleSubmit(event) {
      event.preventDefault();
      
      const btn = document.getElementById('submitBtn');
      
      btn.disabled = true;
      btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sedang mengirim...';
      
      setTimeout(() => {
        document.getElementById('submitForm').submit();
        
        setTimeout(() => {
          const successMsg = document.querySelector('[class*="bg-green"]');
          if (successMsg) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            setTimeout(() => {
              window.location.href = '{{ route("tasks.my-tasks") }}';
            }, 2000);
          }
        }, 500);
      }, 300);
    }
  </script>
@endsection
