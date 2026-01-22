@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('projects.index') }}" class="w-12 h-12 flex items-center justify-center bg-white border-2 border-slate-200 rounded-2xl text-slate-400 hover:text-blue-600 hover:border-blue-600 transition-all shadow-sm">
            <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic uppercase">Inisiasi<span class="text-indigo-600">Proyek</span></h1>
            <p class="text-sm text-slate-500 font-bold mt-1 tracking-widest uppercase">Launch New Project Workspace</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-200 overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-8">
                @csrf
                
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Nama Proyek</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-black text-slate-800 placeholder:text-slate-300 @error('name') border-red-500 @enderror" 
                           placeholder="Masukkan Nama Proyek yang Spesifik"
                           required>
                    @error('name')
                        <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Deskripsi Proyek</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-800 placeholder:text-slate-300 @error('description') border-red-500 @enderror" 
                              placeholder="Deskripsikan tujuan utama, scope, dan target dari proyek ini secara mendalam...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="start_date" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Tanggal Mulai</label>
                        <div class="relative">
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date" 
                                   value="{{ old('start_date') }}"
                                   class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-black text-slate-800 uppercase @error('start_date') border-red-500 @enderror">
                        </div>
                        @error('start_date')
                            <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="end_date" class="block text-xs font-black text-slate-700 uppercase tracking-widest ml-1">Tanggal Deadline</label>
                        <div class="relative">
                            <input type="date" 
                                   name="end_date" 
                                   id="end_date" 
                                   value="{{ old('end_date') }}"
                                   class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-black text-slate-800 uppercase @error('end_date') border-red-500 @enderror">
                        </div>
                        @error('end_date')
                            <p class="mt-1 text-xs font-black text-red-600 uppercase tracking-tight ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-indigo-50 p-6 rounded-3xl border-2 border-indigo-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/100?u=' . urlencode(auth()->user()->email) }}" 
                                 class="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-lg" alt="">
                            <div class="absolute -bottom-1 -right-1 bg-indigo-600 text-white p-1 rounded-lg">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 017 7v1H1v-1a7 7 0 015-6.7z"/></svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] mb-1">Project Manager (Owner)</p>
                            <h4 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ auth()->user()->name }}</h4>
                            <p class="text-xs font-bold text-indigo-800 opacity-60">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="bg-white/50 px-4 py-2 rounded-xl border border-indigo-200">
                        <p class="text-[11px] font-black text-indigo-900 uppercase leading-relaxed italic">"Anda akan memegang otoritas penuh<br>atas manajemen proyek ini."</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 pt-4 border-t-2 border-slate-100">
                    <button type="submit" 
                            class="w-full md:w-auto bg-slate-900 hover:bg-black text-white px-12 py-4 rounded-2xl font-black flex items-center justify-center gap-3 shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-sm">
                        <svg class="w-6 h-6 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Proyek
                    </button>
                    <a href="{{ route('projects.index') }}" 
                       class="w-full md:w-auto bg-slate-100 text-slate-600 px-12 py-4 rounded-2xl hover:bg-slate-200 transition-all font-black uppercase tracking-[0.2em] text-sm text-center border-2 border-slate-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
  </div>
</div>

@if ($errors->any())
<div class="fixed top-4 right-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg shadow-lg">
  <div class="font-medium">Terjadi kesalahan:</div>
  <ul class="list-disc list-inside text-sm mt-1">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@endsection